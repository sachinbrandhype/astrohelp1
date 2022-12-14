const { DataTypes } = require("sequelize");
const { sequelize } = require(".");
const { imagePaths } = require("../config/app.config");
const Op = require('sequelize').Op;
const moment = require('moment');
module.exports = (sequelize, Sequelize) => {
    const transaction = sequelize.define("transactions", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      txn_name: {
        type: Sequelize.STRING
      },
      booking_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      user_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      booking_txn_id: {
        type: Sequelize.STRING
      },
      payment_mode: {
        type: Sequelize.STRING
      },
      type: {
        type: Sequelize.STRING
      },
      old_wallet: {
        type: Sequelize.FLOAT
      },
      txn_amount: {
        type: Sequelize.FLOAT
      },
      txn_for: {
        type: Sequelize.STRING
      },
      update_wallet: {
        type: Sequelize.FLOAT
      },
      gst_amount:{
        type: Sequelize.FLOAT
      },
      gst_perct:{
        type: Sequelize.FLOAT
      },
      payment:{
        type: Sequelize.FLOAT
      },
      status: {
        type: Sequelize.INTEGER
      },
      is_refund: {
        type: Sequelize.INTEGER
      },
      txn_mode: {
        type: Sequelize.STRING
      },
      created_at: {
        type: Sequelize.STRING
      },
      updated_at: {
        type: Sequelize.STRING
      },
      json: {
        type: DataTypes.TEXT
      },
      plan_amount: {
        type: DataTypes.FLOAT
      },
      bank_txn_id: {
        type: Sequelize.STRING
      },
      pg_txn_id:{
        type: Sequelize.STRING
      },
      // txndate: {
      //   type: DataTypes.VIRTUAL,
      //   get() {
      //     return moment(this.created_at,'YYYY-MM-DDTHH:mm:ss').format('DD-MMM-YYYY, hh:mm A')
      //   }
      // },
    },{
        timestamps: false,
        tableName: 'transactions',
        scopes:{
          wallet:{
            where: {
              [Op.or]: [{payment_mode: "wallet"}, {txn_for: "wallet"}]
            }
            // or: [
            //   {
            //     payment_mode: "wallet",
            //   },
            //   {
            //     txn_for: "wallet",
            //   }
            // ]
            
              // $or: [
              //   {
              //     payment_mode: {
              //       $like: 'Boat%'
              //     }
              //   },
              //   {
              //     txn_for: {
              //       $like: '%boat%'
              //     }
              //   }
              // ]
            
          },
          newest:{
            order: [
              ['id','desc'],
            ]
          }
        }
    });

    return transaction;
};