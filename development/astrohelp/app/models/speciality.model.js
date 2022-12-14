const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Speciality = sequelize.define("specialities", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      image: {
        type: Sequelize.STRING
      },
      status: {
        type: Sequelize.INTEGER,
      },
      // position: {
      //   type: Sequelize.INTEGER,
      // },
      description: {
        type: Sequelize.TEXT,
      },
      type: {
        type: Sequelize.INTEGER,
      },
      imageUrl: {
            type: DataTypes.VIRTUAL,
            get() {
                return `${imagePaths.speciality}${this.image}`;
            }
        },

      is_selected: {
          type: DataTypes.VIRTUAL,
          get() {
              return '';
          }
      },
    },{
      tableName:'master_specialization',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
          service:{
            where:{
              type:2
            }
          },
          speciality:{
            where:{
              type:1
            }
          },
        }
    });

    return Speciality;
};