const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Priest = sequelize.define('priest',{

      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      email: {
        type: Sequelize.STRING
      },
      mobile: {
        type: Sequelize.STRING
      },
      dob: {
        type: Sequelize.STRING
      },
      gender: {
        type: Sequelize.STRING
      },
      image: {
        type: Sequelize.STRING
      },

      status: {
        type: Sequelize.INTEGER
      },
    
      imageUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.priest}${this.image}`;
          }
      },
    
    },{
        tableName: 'priest',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return Priest;
};
