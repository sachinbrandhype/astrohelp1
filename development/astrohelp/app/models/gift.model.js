const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const God = sequelize.define("gifts", {
        id: {
            primaryKey: true,
            type: DataTypes.INTEGER,
            autoIncrement: true,
        },
        name: {
            type: DataTypes.STRING
        },
        image: {
            type: DataTypes.STRING
        },
        status:{
            type:DataTypes.INTEGER
        },
        position:{
            type:DataTypes.INTEGER
        },
        price:{
            type:DataTypes.FLOAT
        },
        created_at:{
            type:DataTypes.DATE
        },
        imageUrl: {
            type: DataTypes.VIRTUAL,
            get() {
            return imagePaths.gift +this.image;
            }
        },
        is_selected: {
            type: DataTypes.VIRTUAL,
            get() {
            return '';
            }
        }
    },{
        timestamps: false,
        tableName: 'gifts',
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return God;
};