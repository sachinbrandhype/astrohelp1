const { DataTypes } = require("sequelize");
const { Op } = require('sequelize')
const moment = require('moment')
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Astrologer = sequelize.define('astrologer_notification',{
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      for_: {
        type: DataTypes.STRING
      },
      user_id: {
        type: DataTypes.STRING
      },
      title: {
        type: DataTypes.STRING
      },
      notification: {
        type: DataTypes.STRING
      },
      type: {
        type: DataTypes.STRING
      },
      added_on: {
        type: DataTypes.DATE
      },
      read: {
        type: DataTypes.INTEGER
      },
      booking_id: {
        type: DataTypes.INTEGER
      },
      image: {
        type: DataTypes.STRING
      },
      
    },{
        tableName: 'astrologer_notification',
        timestamps: false,
        defaultScope: {
        },
        scopes:{
        }
    });

    return Astrologer;
};
