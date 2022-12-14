const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Favourite = sequelize.define("favourites", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      astrologer_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at: {
        type: DataTypes.DATE
      },
    },{
        timestamps: false,
        tableName: 'favourites',
        scopes:{
          orderAsc:{
            order: [
              ['created_at','desc'],
            ]
          },
        }
    });

    return Favourite;
};