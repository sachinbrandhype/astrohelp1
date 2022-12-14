const { DataTypes } = require("sequelize");
const { Op } = require('sequelize')
const moment = require('moment')
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Table = sequelize.define('wallet_plans',{
        id: {
            primaryKey: true,
            type: DataTypes.INTEGER,
            autoIncrement: true,
        },
        recharge: {
            type: DataTypes.FLOAT
        },
        benefit: {
            type: DataTypes.FLOAT
        },
        for_new_user: {
            type: DataTypes.INTEGER
        },
        position: {
            type: DataTypes.INTEGER
        },
        created_at: {
            type: DataTypes.DATE
        },
        status:{
            type:DataTypes.INTEGER
        },
        is_selected: {
            type: DataTypes.VIRTUAL,
            get() {
              return ``;
            }
        },
     
    },{
        tableName: 'wallet_plans',
        timestamps: false,
        defaultScope: {
          where: {
           
          }
        },
        scopes:{
          orderAsc:{
              order:[['position','asc']]
          }
        }
    });

    return Table;
};
