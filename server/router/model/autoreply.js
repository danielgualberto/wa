const { db, dbQuery } = require('../../database/index')
require('dotenv').config()
const {
    default: makeWASocket,
    downloadContentFromMessage,
  } = require('@adiwajshing/baileys'),
  axios = require('axios'),
  fs = require('fs')
async function removeForbiddenCharacters(response) {
  let _0x307e9e = ['/', '?', '&', '=', '"']
  for (let _0x22168c of _0x307e9e) {
    response = response.split(_0x22168c).join('')
  }
  return response
}
const autoReply = async (response, token) => {
  try {
    if (!response.messages) {
      return
    }
    response = response.messages[0]
    if (response.key.remoteJid === 'status@broadcast') {
      return
    }
    const result = Object.keys(response.message || {})[0],
      _0x5dfc70 =
        result === 'conversation' && response.message.conversation
          ? response.message.conversation
          : result == 'imageMessage' &&
            response.message.imageMessage.caption
          ? response.message.imageMessage.caption
          : result == 'videoMessage' &&
            response.message.videoMessage.caption
          ? response.message.videoMessage.caption
          : result == 'extendedTextMessage' &&
            response.message.extendedTextMessage.text
          ? response.message.extendedTextMessage.text
          : result == 'messageContextInfo' &&
            response.message.listResponseMessage?.title
          ? response.message.listResponseMessage.title
          : result == 'messageContextInfo'
          ? response.message.buttonsResponseMessage.selectedDisplayText
          : '',
      _0x1ce6f5 = _0x5dfc70.toLowerCase(),
      _0x445ca5 = await removeForbiddenCharacters(_0x1ce6f5),
    //   _0x445ca5 = _0x445ca5.replace(/\|/g, '%" OR keyword LIKE "%'), // Criar IF depois
      _0xcc4dd3 = response?.pushName || '',
      _0x5481d2 = response.key.remoteJid.split('@')[0]
    let _0x39623e
    if (result === 'imageMessage') {
      const _0x16a868 = await downloadContentFromMessage(
        response.message.imageMessage,
        'image'
      )
      let _0x1e84af = Buffer.from([])
      for await (const _0x464cf0 of _0x16a868) {
        _0x1e84af = Buffer.concat([_0x1e84af, _0x464cf0])
      }
      _0x39623e = _0x1e84af.toString('base64')
    } else {
      urlImage = null
    }
    if (response.key.fromMe === true) {
      return
    }
    let _0x3f3e73, _0xa0bfdd
    const _0x58e417 = await dbQuery(
      'SELECT * FROM autoreplies WHERE keyword = "' +
        _0x445ca5 +
        "\" AND type_keyword = 'Equal' AND device = " +
        token.user.id.split(':')[0] +
        ' LIMIT 1'
    )
    if (_0x58e417.length === 0) {
      console.log(_0x445ca5)
      const _0x1b1af9 = await dbQuery(
        'SELECT * FROM autoreplies WHERE LOCATE(keyword, "' +
          _0x445ca5 +
          "\") > 0 AND type_keyword = 'Contain' AND device = " +
          token.user.id.split(':')[0] +
          ' LIMIT 1'
      )
      _0xa0bfdd = _0x1b1af9
    } else {
      _0xa0bfdd = _0x58e417
    }
    if (_0xa0bfdd.length === 0) {
      const _0x339164 = token.user.id.split(':')[0]
      0
      const _0x128e9a = await dbQuery(
          "SELECT webhook FROM numbers WHERE body = '" + _0x339164 + "' LIMIT 1"
        ),
        _0x4f2ef2 = _0x128e9a[0].webhook
      if (_0x4f2ef2 === null) {
        return
      }
      const _0x3506a6 = await sendWebhook({
        command: _0x1ce6f5,
        bufferImage: _0x39623e,
        from: _0x5481d2,
        url: _0x4f2ef2,
      })
      if (_0x3506a6 === false) {
        return
      }
      _0x3f3e73 = JSON.stringify(_0x3506a6)
    } else {
      replyorno =
        _0xa0bfdd[0].reply_when == 'All'
          ? true
          : _0xa0bfdd[0].reply_when == 'Group' &&
            response.key.remoteJid.includes('@g.us')
          ? true
          : _0xa0bfdd[0].reply_when == 'Personal' &&
            !response.key.remoteJid.includes('@g.us')
          ? true
          : false
      if (replyorno === false) {
        return
      }
      _0x3f3e73 =
        process.env.TYPE_SERVER === 'hosting'
          ? _0xa0bfdd[0].reply
          : JSON.stringify(_0xa0bfdd[0].reply)
    }
    _0x3f3e73 = _0x3f3e73.replace(/{name}/g, _0xcc4dd3)
    await token
      .sendMessage(response.key.remoteJid, JSON.parse(_0x3f3e73))
      .catch((_0x1b3fb4) => {
        console.log(_0x1b3fb4)
      })
  } catch (_0x4861a4) {
    console.log(_0x4861a4)
  }
}
async function sendWebhook({
  command: _0x1bc2c1,
  bufferImage: _0x54af04,
  from: sender,
  url: _0x418370,
}) {
  try {
    const _0x53bc08 = {
        message: _0x1bc2c1,
        bufferImage: _0x54af04,
        from: sender,
      },
      _0x244a21 = { 'Content-Type': 'application/json; charset=utf-8' },
      result = await axios
        .post(_0x418370, _0x53bc08, _0x244a21)
        .catch(() => {
          return false
        })
    return result.data
  } catch (error) {
    return console.log(error), false
  }
}
module.exports = { autoReply: autoReply }
