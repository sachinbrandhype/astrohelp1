const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
const { Op } = require('sequelize')

const moment = require("moment");

module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("broadcasts", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      astrologer_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      title: {
        type: DataTypes.STRING
      },
      description: {
        type: DataTypes.STRING
      },
      status: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      start_time: {
        type: DataTypes.DATE
      },
      end_time: {
        type: DataTypes.DATE
      },
      total_minutes: {
        type: DataTypes.STRING
      },
      total_seconds: {
        type: DataTypes.STRING
      },
      bridge_id	: {
        type: DataTypes.STRING
      },
      created_at	: {
        type: DataTypes.DATE
      },
      price:{
        type:DataTypes.FLOAT
      },
      language:{
        type:DataTypes.STRING
      },
      gifts_id:{
        type:DataTypes.STRING
      },
      is_approved:{
        type:DataTypes.INTEGER
      },
      is_gift_added:{
        type:DataTypes.VIRTUAL,
        get() {
          if(this.gifts_id){
            return 1;
          }else{
            return 0 ;
          }
        }

      },
      can_start:{
        type:DataTypes.VIRTUAL,
        get() {
          if(this.start_time && this.end_time && this.is_approved==1){
            const m_start = moment(this.start_time);
            const m_end = moment(this.end_time);
            const tim = moment();
            if (tim.isBetween(m_start, m_end)) {
              return '1';
            }else{
              return '0';
            }
          }else{
            return '0';
          }
        }
      }

    },{
        timestamps: false,
        tableName: 'broadcasts',
        scopes:{
          not_start:{
            where:{status:0}
          },
          approved:{
            where:{is_approved:1}
          },
          start:{
            where:{status:1}
          },
          end:{
            where:{status:2}
          },
          pending_start : {
            where:{
              status:{
                [Op.in]:[0,1]
              }
            }
          },
          orderAsc:{
            order: [
              ['start_time','asc'],
            ]
          },
          orderDesc:{
            order: [
              ['position','desc'],
            ]
          },
        }
    });

    return Banner;
};