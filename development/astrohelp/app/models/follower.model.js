const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Gallery = sequelize.define("followers", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      astrologer_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at: {
        type: DataTypes.DATE
      },
    //   imageUrl: {
    //         type: DataTypes.VIRTUAL,
    //         get() {
    //             return `${imagePaths.banner}${this.image}`;
    //         }
    //     }
    },{
        timestamps: false,
        tableName: 'followers',
        scopes:{
        }
    });

    return Gallery;
};