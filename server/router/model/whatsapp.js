'use strict'
const { Boom } = require('@hapi/boom'),
  {
    default: makeWASocket,
    makeWALegacySocket,
    downloadContentFromMessage,
  } = require('@adiwajshing/baileys'),
  {
    fetchLatestBaileysVersion,
    useMultiFileAuthState,
    makeCacheableSignalKeyStore,
  } = require('@adiwajshing/baileys'),
  { DisconnectReason } = require('@adiwajshing/baileys'),
  QRCode = require('qrcode'),
  lib = require('../../lib'),
  fs = require('fs')
let sock = [],
  qrcode = [],
  intervalStore = []
const { setStatus } = require('../../database/index'),
  { autoReply } = require('./autoreply'),
  { formatReceipt } = require('../helper'),
  axios = require('axios'),
  MAIN_LOGGER = require('../../lib/pino'),
  logger = MAIN_LOGGER.child({}),
  useStore = !process.argv.includes('--no-store'),
  msgRetryCounterMap = () => (MessageRetryMap = {}),
  connectToWhatsApp = async (sender, socket = null) => {
    if (typeof qrcode[sender] !== 'undefined') {
      return (
        socket !== null &&
          socket.emit('qrcode', {
            token: sender,
            data: qrcode[sender],
            message: 'please scan with your WhatsApp Account',
          }),
        {
          status: false,
          sock: sock[sender],
          qrcode: qrcode[sender],
          message: 'Please scann qrcode',
        }
      )
    }
    try {
      let receiver = sock[sender].user.id.split(':')
      receiver = receiver[0] + '@s.whatsapp.net'
      const ppUrl = await getPpUrl(sender, receiver)
      return (
        socket !== null &&
          socket.emit('connection-open', {
            token: sender,
            user: sock[sender].user,
            ppUrl: ppUrl,
          }),
        {
          status: true,
          message: 'Already connected',
        }
      )
    } catch (error) {
      socket !== null &&
        socket.emit('message', {
          token: sender,
          message: 'Connecting..',
        })
    }
    const { state: auth_state, saveCreds: cred_object } =
        await useMultiFileAuthState('./credentials/' + sender),
      browser = await getChromeLates()
    console.log(
      'You are using WhatsApp Gateway Version: 1.0'
    )
    const { version: version, isLatest: isLatest } =
      await fetchLatestBaileysVersion()
    return (
      console.log(
        'using WA v' + version.join('.') + ', isLatest: ' + isLatest
      ),
      (sock[sender] = makeWASocket({
        version: version,
        browser: ['WayFlow', 'Chrome', browser?.data?.versions[0]?.version],
        logger: logger,
        printQRInTerminal: true,
        auth: {
          creds: auth_state.creds,
          keys: makeCacheableSignalKeyStore(auth_state.keys, logger),
        },
      })),
      sock[sender].ev.process(async (message_data) => {
        if (message_data['connection.update']) {
          const update = message_data['connection.update'],
            {
              connection: connector,
              lastDisconnect: last_session,
              qr: qr_data,
            } = update
          if (connector == 'close') {
            if (
              (last_session?.error)?.output?.statusCode !==
              DisconnectReason.loggedOut
            ) {
              delete qrcode[sender]
              if (socket != null) {
                socket.emit('message', {
                  token: sender,
                  message: 'Connecting..',
                })
              }
              if (
                last_session.error?.output?.payload?.message ===
                'QR refs attempts ended'
              ) {
                delete qrcode[sender]
                sock[sender].ws.close()
                if (socket != null) {
                  socket.emit('message', {
                    token: sender,
                    message:
                      'Request QR ended. reload scan to request QR again',
                  })
                }
                return
              }
              connectToWhatsApp(sender, socket)
            } else {
              setStatus(sender, 'Disconnect')
              console.log('Connection closed. You are logged out.')
              socket !== null &&
                socket.emit('message', {
                  token: sender,
                  message: 'Connection closed. You are logged out.',
                })
              clearConnection(sender)
            }
          }
          qr_data &&
            QRCode.toDataURL(qr_data, function (send_qr_data, rec_data) {
              send_qr_data && console.log(send_qr_data)
              qrcode[sender] = rec_data
              socket !== null &&
                socket.emit('qrcode', {
                  token: sender,
                  data: rec_data,
                  message: 'Please scan with your Whatsapp Account',
                })
            })
          if (connector === 'open') {
            setStatus(sender, 'Connected')
            let output_splitted = sock[sender].user.id.split(':')
            output_splitted = output_splitted[0] + '@s.whatsapp.net'
            const dp_url = await getPpUrl(sender, output_splitted)
            socket !== null &&
              socket.emit('connection-open', {
                token: sender,
                user: sock[sender].user,
                ppUrl: dp_url,
              })
            delete qrcode[sender]
          }
        }
        if (message_data['messages.upsert']) {
          const update = message_data['messages.upsert']
          autoReply(update, sock[sender])
        }
        if (message_data['creds.update']) {
          const update = message_data['creds.update']
          cred_object(update)
        }
      }),
      {
        sock: sock[sender],
        qrcode: qrcode[sender],
      }
    )
  }
async function connectWaBeforeSend(data) {
  let result = undefined,
    client
  client = await connectToWhatsApp(data)
  await client.sock.ev.on('connection.update', (request) => {
    const { connection: connector, qr: qr_code } = request
    connector === 'open' && (result = true)
    qr_code && (result = false)
  })
  let count = 0
  while (typeof result === 'undefined') {
    count++
    if (count > 4) {
      break
    }
    await new Promise((reconnect) => setTimeout(reconnect, 1000))
  }
  return result
}

const sendText = async (sender, receiver, message) => {
    try {
      const result = await sock[sender].sendMessage(
        formatReceipt(receiver),
        { text: message }
      )
      return result
    } catch (error) {
      return console.log(error), false
    }
  },
  sendMessage = async (sender, receiver, message) => {
    try {
      const result = await sock[sender].sendMessage(
        formatReceipt(receiver),
        JSON.parse(message)
      )
      return result
    } catch (error) {
      return console.log(error), false
    }
  }
  
async function sendMedia(
  sender,
  receiver,
  type,
  url,
  option,
  caption
) {
  const formatted_receiver = formatReceipt(receiver)
  try {
    if (type == 'image') {
      var message = await sock[sender].sendMessage(formatted_receiver, {
        image: url
          ? { url: url }
          : fs.readFileSync('src/public/temp/' + option),
        caption: caption ? caption : null,
      })
    } else {
      if (type == 'video') {
        var message = await sock[sender].sendMessage(formatted_receiver, {
          video: url
            ? { url: url }
            : fs.readFileSync('src/public/temp/' + option),
          caption: caption ? caption : null,
        })
      } else {
        if (type == 'audio') {
          var message = await sock[sender].sendMessage(formatted_receiver, {
            audio: url
              ? { url: url }
              : fs.readFileSync('src/public/temp/' + option),
            caption: caption ? caption : null,
          })
        } else {
          if (type == 'pdf') {
            var message = await sock[sender].sendMessage(
              formatted_receiver,
              {
                document: { url: url },
                mimetype: 'application/pdf',
              },
              { url: url }
            )
          } else {
            if (type == 'xls') {
              var message = await sock[sender].sendMessage(
                formatted_receiver,
                {
                  document: { url: url },
                  mimetype: 'application/excel',
                },
                { url: url }
              )
            } else {
              if (type == 'xls') {
                var message = await sock[sender].sendMessage(
                  formatted_receiver,
                  {
                    document: { url: url },
                    mimetype: 'application/excel',
                  },
                  { url: url }
                )
              } else {
                if (type == 'xlsx') {
                  var message = await sock[sender].sendMessage(
                    formatted_receiver,
                    {
                      document: { url: url },
                      mimetype:
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    },
                    { url: url }
                  )
                } else {
                  if (type == 'doc') {
                    var message = await sock[sender].sendMessage(
                      formatted_receiver,
                      {
                        document: { url: url },
                        mimetype: 'application/msword',
                      },
                      { url: url }
                    )
                  } else {
                    if (type == 'docx') {
                      var message = await sock[sender].sendMessage(
                        formatted_receiver,
                        {
                          document: { url: url },
                          mimetype:
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        },
                        { url: url }
                      )
                    } else {
                      if (type == 'zip') {
                        var message = await sock[sender].sendMessage(
                          formatted_receiver,
                          {
                            document: { url: url },
                            mimetype: 'application/zip',
                          },
                          { url: url }
                        )
                      } else {
                        if (type == 'mp3') {
                          var message = await sock[sender].sendMessage(
                            formatted_receiver,
                            {
                              document: { url: url },
                              mimetype: 'application/mp3',
                            },
                            { url: url }
                          )
                        } else {
                          return (
                            console.log('Please add your won role of mimetype'),
                            false
                          )
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    return message
  } catch (error) {
    return console.log(error), false
  }
}

async function sendButtonMessage(
  sender,
  receiver,
  type,
  caption,
  footer,
  url
) {
  let downloadFilePath = 'url'
  try {
    const button = type.map((displayText, Id) => {
      return (
        console.log(displayText),
        {
          buttonId: Id,
          buttonText: { displayText: displayText.displayText },
          type: 1,
        }
      )
    })
    if (url) {
      var message = {
        image:
          downloadFilePath == 'url'
            ? { url: url }
            : fs.readFileSync('src/public/temp/' + url),
        caption: caption,
        footer: footer,
        buttons: button,
        headerType: 4,
      }
    } else {
      var message = {
        text: caption,
        footer: footer,
        buttons: button,
        headerType: 1,
      }
    }
    const result = await sock[sender].sendMessage(
      formatReceipt(receiver),
      message
    )
    return result
  } catch (error) {
    return console.log(error), false
  }
}

async function sendTemplateMessage(
  sender,
  receiver,
  button_obj,
  caption,
  footer,
  downloadFilePath
) {
  try {
    if (downloadFilePath) {
      var message = {
        caption: caption,
        footer: footer,
        templateButtons: button_obj,
        image: { url: downloadFilePath },
        viewOnce: true,
      }
    } else {
      var message = {
        text: caption,
        footer: footer,
        templateButtons: button_obj,
        viewOnce: true,
      }
    }
    const result = await sock[sender].sendMessage(
      formatReceipt(receiver),
      message
    )
    return result
  } catch (error) {
    return console.log(error), false
  }
}
async function sendListMessage(
  sender,
  receiver,
  list,
  text,
  footer,
  title,
  button
) {
  try {
    const message = {
        text: text,
        footer: footer,
        title: title,
        buttonText: button,
        sections: [list],
      },
      result = await sock[sender].sendMessage(
        formatReceipt(receiver),
        message
      )
    return result
  } catch (error) {
    return console.log(error), false
  }
}

async function fetchGroups(sender) {
  try {
    let result = await sock[sender].groupFetchAllParticipating(),
      contacts = Object.entries(result)
        .slice(0)
        .map((_0x58c437) => _0x58c437[1])
    return contacts
  } catch (error) {
    return false
  }
}

async function isExist(sender, receiver) {
  if (typeof sock[sender] === 'undefined') {
    const connector = await connectWaBeforeSend(sender)
    if (!connector) {
      return false
    }
  }
  try {
    if (receiver.includes('@g.us')) {
      return true
    } else {
      const [result] = await sock[sender].onWhatsApp(receiver)
      return result
    }
  } catch (error) {
    return false
  }
}

async function getPpUrl(phone_sender, whatsapp_id, dp_url) {
  let result
  try {
    return (
      (result = await sock[phone_sender].profilePictureUrl(whatsapp_id, 'image')),
      result
    )
  } catch (error) {
    return 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png'
  }
}

async function deleteCredentials(sender, new_socket = null) {
  new_socket !== null &&
    new_socket.emit('message', {
      token: sender,
      message: 'Logout Progres..',
    })
  try {
    if (typeof sock[sender] === 'undefined') {
      const new_socket = await connectWaBeforeSend(sender)
      new_socket && (sock[sender].logout(), delete sock[sender])
    } else {
      sock[sender].logout()
      delete sock[sender]
    }
    return (
      delete qrcode[sender],
      clearInterval(intervalStore[sender]),
      setStatus(sender, 'Disconnect'),
      new_socket != null &&
        (new_socket.emit('Unauthorized', sender),
        new_socket.emit('message', {
          token: sender,
          message: 'Connection closed. You are logged out.',
        })),
      fs.existsSync('./credentials/' + sender) &&
        fs.rmSync(
          './credentials/' + sender,
          {
            recursive: true,
            force: true,
          },
          (success) => {
            if (success) {
              console.log(success)
            }
          }
        ),
      {
        status: true,
        message: 'Deleting session and credential',
      }
    )
  } catch (error) {
    return (
      console.log(error),
      {
        status: true,
        message: 'Nothing deleted',
      }
    )
  }
}
async function getChromeLates() {
  const result = await axios.get(
    'https://versionhistory.googleapis.com/v1/chrome/platforms/linux/channels/stable/versions'
  )
  return result
}

function clearConnection(sender) {
  clearInterval(intervalStore[sender])
  delete sock[sender]
  delete qrcode[sender]
  setStatus(sender, 'Disconnect')
  fs.existsSync('./credentials/' + sender) &&
    (fs.rmSync(
      './credentials/' + sender,
      {
        recursive: true,
        force: true,
      },
      (success) => {
        if (success) {
          console.log(success)
        }
      }
    ),
    console.log('credentials/' + sender + ' is deleted'))
}

async function initialize(token, response) {
  const { token: sender } = token.body
  if (sender) {
    const fs = require('fs'),
      path = './credentials/' + sender
    if (fs.existsSync(path)) {
      sock[sender] = undefined
      const connect = await connectWaBeforeSend(sender)
      return connect
        ? response.status(200).json({
            status: true,
            message: 'Connection restored',
          })
        : response.status(200).json({
            status: false,
            message: 'Connection failed',
          })
    }
    return response.send({
      status: false,
      message: sender + ' Connection failed,please scan first',
    })
  }
  return response.send({
    status: false,
    message: 'Wrong Parameterss',
  })
}

module.exports = {
  connectToWhatsApp: connectToWhatsApp,
  sendText: sendText,
  sendMedia: sendMedia,
  sendButtonMessage: sendButtonMessage,
  sendTemplateMessage: sendTemplateMessage,
  sendListMessage: sendListMessage,
  isExist: isExist,
  getPpUrl: getPpUrl,
  fetchGroups: fetchGroups,
  deleteCredentials: deleteCredentials,
  sendMessage: sendMessage,
  initialize: initialize,
  connectWaBeforeSend: connectWaBeforeSend,
}
