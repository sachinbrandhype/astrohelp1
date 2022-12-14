const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("astrologer_discounts", {
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        type : {
            type:DataTypes.STRING
        },
        astrologer_id : {
            type:DataTypes.INTEGER
        },
        discount_percentage : {
            type:DataTypes.INTEGER
        },
        start_date : {
            type:DataTypes.DATE
        },
        end_date : {
            type:DataTypes.DATE
        },
        created_at : {
            type:DataTypes.DATE
        },
        updated_at : {
            type:DataTypes.DATE
        },
    },{
        timestamps: false,
        tableName: 'astrologer_discounts',
        scopes:{
          
        }
    });

    return Banner;
};