const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const booking = sequelize.define("booking_history", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER,
      },
      astrologer_id: {
        type: DataTypes.INTEGER,
      },
      member_id: {
        type: DataTypes.INTEGER,
      },
      price_per_mint: {
        type: DataTypes.FLOAT
      },
      type: {
        type: DataTypes.INTEGER,
      },
      status: {
        type: DataTypes.INTEGER,
      },
      accept_date	: {
        type: DataTypes.DATE,

      },
      reject_date	: {
        type: DataTypes.DATE,

      },
      created_at	: {
        type: DataTypes.DATE,

      },
    },{
        timestamps: false,
        tableName: 'booking_request',
    });

    return booking;
};