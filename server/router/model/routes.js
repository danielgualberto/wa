'use strict'
const wa = require('./whatsapp'),
  lib = require('../../lib'),
  { dbQuery } = require('../../database'),
  { asyncForEach, formatReceipt } = require('../helper'),
  createInstance = async (token, response) => {
    const { token: sender } = token.body
    if (sender) {
      try {
        const connect = await wa.connectToWhatsApp(sender, token.io),
          status = connect?.status,
          message = connect?.message
        return response.send({
          status: status ?? 'processing',
          qrcode: connect?.qrcode,
          message: message ? message : 'Processing',
        })
      } catch (error) {
        return (
          console.log(error),
          response.send({
            status: false,
            error: error,
          })
        )
      }
    }
    response.status(403).end('Token needed')
  },
  sendText = async (token, response) => {
    const {
      token: sender,
      number: receiver,
      text: message,
    } = token.body
    if (sender && receiver && message) {
      let is_alive = await wa.isExist(sender, formatReceipt(receiver))
      if (!is_alive) {
        return response.send({
          status: false,
          message:
            'The destination Number not registered in whatsapp or your sender not connected',
        })
      }
      const result = await wa.sendText(sender, receiver, message)
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your whatsapp connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameter',
    })
  },
  sendMedia = async (token, response) => {
    const {
      token: sender,
      number: receiver,
      type: type,
      url: url,
      fileName: option,
      caption: caption,
    } = token.body
    if (sender && receiver && type && url && caption) {
      let is_alive = await wa.isExist(sender, formatReceipt(receiver))
      if (!is_alive) {
        return response.send({
          status: false,
          message:
            'The destination Number not registered in whatsapp or your sender not connected',
        })
      }
      const result = await wa.sendMedia(
        sender,
        receiver,
        type,
        url,
        option,
        caption
      )
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameter',
    })
  },
  sendButtonMessage = async (token, response) => {
    const {
        token: sender,
        number: receiver,
        button: button,
        message: message,
        footer: footer,
        image: url,
      } = token.body,
      type = JSON.parse(button)
    if (sender && receiver && button && message && footer) {
      let is_alive = await wa.isExist(sender, formatReceipt(receiver))
      if (!is_alive) {
        return response.send({
          status: false,
          message:
            'The destination Number not registered in whatsapp or your sender not connected',
        })
      }
      const result = await wa.sendButtonMessage(
        sender,
        receiver,
        type,
        message,
        footer,
        url
      )
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameterr',
    })
  },
  sendTemplateMessage = async (token, response) => {
    const {
      token: sender,
      number: receiver,
      button: button_obj,
      text: message,
      footer: footer,
      image: url,
    } = token.body
    if (sender && receiver && button_obj && message && footer) {
      let is_alive = await wa.isExist(sender, formatReceipt(receiver))
      if (!is_alive) {
        return response.send({
          status: false,
          message:
            'The destination Number not registered in whatsapp or your sender not connected',
        })
      }
      const result = await wa.sendTemplateMessage(
        sender,
        receiver,
        JSON.parse(button_obj),
        message,
        footer,
        url
      )
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameter',
    })
  },
  sendListMessage = async (token, response) => {
    const {
      token: sender,
      number: receiver,
      list: list,
      text: message,
      footer: footer,
      title: title,
      buttonText: button,
    } = token.body
    if (
      sender &&
      receiver &&
      list &&
      message &&
      footer &&
      title &&
      button
    ) {
      let is_alive = await wa.isExist(sender, formatReceipt(receiver))
      if (!is_alive) {
        return response.send({
          status: false,
          message:
            'The destination Number not registered in whatsapp or your sender not connected',
        })
      }
      const result = await wa.sendListMessage(
        sender,
        receiver,
        JSON.parse(list),
        message,
        footer,
        title,
        button
      )
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameterr',
    })
  },
  fetchGroups = async (token, response) => {
    const { token: sender } = token.body
    if (sender) {
      const result = await wa.fetchGroups(sender)
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameter',
    })
  },
  blast = async (token, response) => {
    const message = token.body.data,
      receiver = JSON.parse(message),
      is_alive = await wa.isExist(
        receiver[0].sender,
        formatReceipt(receiver[0].sender)
      )
    if (!is_alive) {
      return response.send({
        status: false,
        message: 'Check your whatsapp connection',
      })
    }
    let success = [],
      failed = []
    function blast(result) {
      return new Promise((reconnect) => {
        setTimeout(() => {
          reconnect('')
        }, result)
      })
    }
    return (
      await asyncForEach(receiver, async (result, sender) => {
        const {
          sender: token,
          receiver: number,
          message: message,
          campaign_id: campaign_id,
        } = result
        if (token && number && message) {
          const result = await wa.sendMessage(
            token,
            number,
            message
          )
          result ? success.push(number) : failed.push(number)
        }
        await blast(1000)
      }),
      response.send({
        status: true,
        success: success,
        failed: failed,
      })
    )
  },
  deleteCredentials = async (token, response) => {
    const { token: sender } = token.body
    if (sender) {
      const result = await wa.deleteCredentials(sender)
      if (result) {
        return response.send({
          status: true,
          data: result,
        })
      }
      return response.send({
        status: false,
        message: 'Check your connection',
      })
    }
    response.send({
      status: false,
      message: 'Check your parameter',
    })
  }
module.exports = {
  createInstance: createInstance,
  sendText: sendText,
  sendMedia: sendMedia,
  sendButtonMessage: sendButtonMessage,
  sendTemplateMessage: sendTemplateMessage,
  sendListMessage: sendListMessage,
  deleteCredentials: deleteCredentials,
  fetchGroups: fetchGroups,
  blast: blast,
}
