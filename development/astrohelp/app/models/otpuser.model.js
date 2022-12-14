const { DataTypes } = require("sequelize");

module.exports = (sequelize, Sequelize) => {
    const Otpuser = sequelize.define("otp_users", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_type: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      name: {
        type: DataTypes.STRING
      },
      email: {
        type: DataTypes.STRING
      },
      password: {
        type: DataTypes.STRING
      },
      phone: {
        type: DataTypes.STRING
      },
      gender: {
        type: DataTypes.STRING
      },
      otp: {
        type: DataTypes.STRING
      },
      email_verified: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      phone_verified: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at: {
        type: DataTypes.DATE
      },
      updated_at: {
        type: DataTypes.DATE
      },
      is_verified: {
        type: DataTypes.INTEGER
      },
      token: {
        type: DataTypes.STRING
      },
    },{
        timestamps: false
    });

    return Otpuser;
};