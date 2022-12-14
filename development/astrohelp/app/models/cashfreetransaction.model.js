const { DataTypes } = require("sequelize");
const { Op } = require('sequelize')
const moment = require('moment')
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Astrologer = sequelize.define('cashfree_transaction',{
        id: {
            primaryKey: true,
            type: DataTypes.INTEGER,
            autoIncrement: true,
        },
        user_id:{
            type: DataTypes.INTEGER,
        },
        order_id:{
            type: DataTypes.STRING
        },
        jsondata:{
            type : DataTypes.TEXT
        },
        status:{
            type:DataTypes.INTEGER
        },
        amount:{
            type : DataTypes.FLOAT
        },
        created_at :{
            type: DataTypes.DATE

        }
        
     
    },{
        tableName: 'cashfree_transaction',
        timestamps: false,
        scopes:{
         
        }
    });

    return Astrologer;
};
