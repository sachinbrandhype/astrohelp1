const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const Referralcodehistory = sequelize.define("referral_code_history", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      referral_from: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      referral_to: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      is_used: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      code: {
        type: DataTypes.STRING
      },

      refer_to_wallet_add:{
        type: DataTypes.FLOAT
      },
      previous_wallet_refert_to:{
        type: DataTypes.FLOAT
      },
      updated_wallet_refert_to:{
        type: DataTypes.FLOAT
      },
      refer_by_wallet_add:{
        type: DataTypes.FLOAT

      },
      previous_wallet_refert_by:{
        type: DataTypes.FLOAT

      },
      updated_wallet_refert_by	:{
        type: DataTypes.FLOAT

      },
      order_id:{
        type: DataTypes.INTEGER

      },
      added_on: {
        type: DataTypes.DATE

      },
      refer_transfer_date: {
        type: DataTypes.DATE

      },
    },{
        timestamps: false,
        tableName: 'referral_code_history',
        scopes:{
        }
    });

    return Referralcodehistory;
};