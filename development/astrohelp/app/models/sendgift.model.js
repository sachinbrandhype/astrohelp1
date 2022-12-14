const { DataTypes } = require("sequelize");

const { imagePaths } = require("../config/app.config");

// const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const Ropeway = sequelize.define("send_gifts", {
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        user_id:{
            type:DataTypes.INTEGER
        },
        broadcast_id:{
            type:DataTypes.INTEGER
        },
        user_name:{
            type:DataTypes.STRING
        },
        user_image:{
            type:DataTypes.STRING
        },
        gift_id:{
            type:DataTypes.INTEGER
        },
        gift_name:{
            type:DataTypes.STRING
        },
        astrologer_id:{
            type:DataTypes.INTEGER
        },
        price:{
            type:DataTypes.FLOAT
        },
        user_txn_id:{
            type:DataTypes.STRING
        },
        astrologer_txn_id:{
            type:DataTypes.STRING
        },
        created_at:{
            type:DataTypes.DATE
        }
    },{
        tableName:'send_gifts',
        timestamps: false,
        scopes:{
        }
    });

    return Ropeway;
};