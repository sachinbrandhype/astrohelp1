const moment = require("moment");
const currentdate = moment().format();;
const { Op } = require('sequelize')

module.exports = (sequelize, Sequelize) => {
    const Coupon = sequelize.define("coupan", {
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        heading:{
            type:Sequelize.STRING
        },
        description:{
            type:Sequelize.STRING
        },
        code:{
            type:Sequelize.STRING
        },
        uses_limit:{
            type:Sequelize.INTEGER
        },
        discount_type:{
            type:Sequelize.STRING
        },
        amount:{
            type:Sequelize.FLOAT
        },
        discount_on:{
            type:Sequelize.INTEGER
        },
        start_date:{
            type:Sequelize.STRING
        },
        expiry_date:{
            type:Sequelize.STRING
        },
        status: {
            type: Sequelize.INTEGER.UNSIGNED
        },
        added_on:{
            type:'TIMESTAMP'
        },
        added_by:{
            type:Sequelize.INTEGER
        },
        total_used:{
            type:Sequelize.INTEGER
        },
        is_public:{
            type:Sequelize.INTEGER
        },
    },{
        timestamps: false,
        tableName: 'coupan',
        // myMoment.diff(this.start_date) >= 0
        scopes:{
          active:{
            where:{
                status:1,
                // start_date: {
                //     [Op.gte]: currentdate
                // },
                // expiry_date: {
                //     [Op.lte]: currentdate
                // },
            }
          },
          puja:{
            where:{discount_on:1}
          },
          horoscope:{
            where:{discount_on:3}
          },
          astrologer :{
              where:{
                discount_on:4
              }
          }
        }
    });

    return Coupon;
};