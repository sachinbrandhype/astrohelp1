const { Op } = require("sequelize")
const { top_astrologers } = require("../controllers/home.controller");
const { successRes, failedRes } = require("../helpers/response.helper");
module.exports = (io,socket) => {

    socket.on('top_astrologers',async req => {
        const data = await top_astrologers();
        io.emit('top_astrologers', data ? successRes('success',data) : failedRes('',[]))
    })

}

