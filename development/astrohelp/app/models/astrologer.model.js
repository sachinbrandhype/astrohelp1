const { DataTypes } = require("sequelize");
const { Op } = require('sequelize')
const moment = require('moment')
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Astrologer = sequelize.define('astrologers',{
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: DataTypes.STRING
      },
      image: {
        type: DataTypes.STRING
      },
      country:{
        type: DataTypes.STRING
      },
      bio: {
        type: DataTypes.TEXT
      },
      price_per_mint_chat: {
        type: DataTypes.FLOAT
      },
      price_per_mint_video: {
        type: DataTypes.FLOAT
      },
      price_per_mint_audio: {
        type: DataTypes.FLOAT
      },
      price_per_mint_broadcast:{
        type: DataTypes.FLOAT
      },
      discount:{
        type: DataTypes.FLOAT
      },
      time_on_amount: {
        type: DataTypes.TEXT
      },
      share_percentage: {
        type: DataTypes.FLOAT
      },
      online_counsult_time: {
        type: DataTypes.TEXT
      },
      added_on: {
        type: DataTypes.DATE
      },
      location:{
        type: DataTypes.STRING
      },
      latitude: {
        type: DataTypes.STRING
      },
      longitude: {
        type: DataTypes.STRING
      },
      languages: {
        type: DataTypes.STRING
      },
      vacation_time: {
        type: DataTypes.STRING
      },
      vacation_for: {
        type: DataTypes.INTEGER
      },
      email: {
        type: DataTypes.STRING
      },
      phone: {
        type: DataTypes.STRING
      },
      password: {
        type: DataTypes.STRING
      },
      device_id: {
        type: DataTypes.STRING
      },
      device_type: {
        type: DataTypes.STRING
      },
      device_token : {
        type: DataTypes.TEXT
      },
      model_name: {
        type: DataTypes.STRING
      },
      loginTime: {
        type: DataTypes.STRING
      },
      expertise	 : {
        type: DataTypes.TEXT
      },
      experience: {
        type: DataTypes.STRING
      },
      status: {
        type: DataTypes.INTEGER
      },
      is_approval: {
        type: DataTypes.INTEGER
      },
      online_consult: {
        type: DataTypes.INTEGER
      },
      online_status: {
        type: DataTypes.INTEGER
      },
      register_from: {
        type: DataTypes.INTEGER
      },

      is_premium: {
        type: DataTypes.INTEGER
      },
      approved	: {
        type: DataTypes.INTEGER
      },
      live_consult	: {
        type: DataTypes.INTEGER
      },
      can_take_horoscope	: {
        type: DataTypes.INTEGER
      },
      horoscope_price: {
        type: DataTypes.FLOAT
      },
      discount_on:{
        type: DataTypes.STRING
      },
      discount_start:{
        type: DataTypes.STRING
      },
      discount_end:{
        type: DataTypes.STRING
      },
      
      chat_position: {
        type: DataTypes.INTEGER
      },
      video_position: {
        type: DataTypes.INTEGER
      },
      audio_position: {
        type: DataTypes.INTEGER
      },
      rating:{
        type:DataTypes.STRING
      },

      award_status:{
        type:DataTypes.STRING
      },

      imageUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.astrologer}${this.image}`;
          }
      },
      is_new: {
          type: DataTypes.VIRTUAL,
          get() {
            return 0;
          }
      }
    },{
        tableName: 'astrologers',
        timestamps: false,
        defaultScope: {
          // where: {
          //   approved:1,
          //   status:1
          // }
        },
        scopes:{
          active:{
            where:{status:1, 
            // is_approval: {
            //   [Op.ne]:0
            // },
            approved:1}
          },
          scheduleAstro:{
            where:{is_approval:1}
          },
          online:{
            where:{online_status:1}
          },
          realtimeAstro:{
            where:{is_approval:2}
          },
        }
    });

    return Astrologer;
};
