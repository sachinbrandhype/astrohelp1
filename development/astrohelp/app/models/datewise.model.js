const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Puja = sequelize.define('puja_time_slots',{
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        puja_id: {
            type: Sequelize.INTEGER
        },
        date:{
            type:Sequelize.STRING
        },
        json:{
            type:Sequelize.TEXT
        },
        stock:{
            type:Sequelize.INTEGER
        }
        // var gallery_imgs = await lc.gallery.split("|");
    },{
        tableName: 'puja_time_slots',
        timestamps: false,
        scopes:{

        }
    });

    return Puja;
};
