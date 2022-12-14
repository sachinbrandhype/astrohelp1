const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("broadcast_join", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      broadcast_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      bridge_id: {
        type: DataTypes.STRING
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      astrologer_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      status: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at	: {
        type: DataTypes.DATE
      },

    },{
        timestamps: false,
        tableName: 'broadcast_join',
        scopes:{
          join:{
            where:{status:1}
          },
          leave:{
            where:{status:2}
          },
          newest:{
            order:[['created_at','desc']]
          },
        }
    });

    return Banner;
};