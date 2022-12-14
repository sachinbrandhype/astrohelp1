// const { DataTypes } = require("sequelize");
const moment = require("moment");
const { DataTypes } = require("sequelize");

const { imagePaths } = require("../config/app.config");


module.exports = (sequelize, Sequelize) => {
    const Review = sequelize.define("reviews", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      type: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      type_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      booking_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      rate: {
        type: DataTypes.STRING
      },
      message: {
        type: DataTypes.TEXT
      },
      reply_message: {
        type: DataTypes.TEXT
      },
      is_reply: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      status: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at: {
        type: DataTypes.DATE,
      },
      updated_at: {
        type: DataTypes.DATE
      },
      added: {
        type: DataTypes.VIRTUAL,
        get() {
          return moment(this.created_at,["YYYY-MM-DD HH:mm:ss"]).format('DD MMM YYYY hh:mma');
      }}
    },{
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
          puja:{
            where:{type:1}
          },
          astrologer:{
            where:{type:2}
          },
        }
    });

    return Review;
};