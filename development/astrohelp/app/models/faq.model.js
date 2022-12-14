const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const FAQ = sequelize.define("f_a_q_s", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      question: {
        type: Sequelize.STRING
      },
      answer: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      position: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
    //   added_on: {
    //     type: Sequelize.INTEGER
    //   },
    //   imageUrl: {
    //         type: DataTypes.VIRTUAL,
    //         get() {
    //             return `${imagePaths.banner}${this.image}`;
    //         }
    //     }
    },{
        timestamps: false,
        tableName: 'f_a_q_s',
        scopes:{
          active:{
            where:{status:1}
          },
          orderAsc:{
            order: [
              ['position','asc'],
            ]
          },
        }
    });

    return FAQ;
};