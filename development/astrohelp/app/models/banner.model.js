const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("banner", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      link_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      link_type: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      name: {
        type: Sequelize.STRING
      },
      position: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      image: {
        type: Sequelize.STRING
      },
      type: {
        type: Sequelize.STRING
      },
      is_active: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      added_on: {
        type: Sequelize.STRING
      },
      imageUrl: {
            type: DataTypes.VIRTUAL,
            get() {
                return `${imagePaths.banner}${this.image}`;
            }
        }
    },{
        timestamps: false,
        tableName: 'banner',
        scopes:{
          active:{
            where:{is_active:1}
          },
          main:{
            where:{type:'main'}
          },
          mid:{
            where:{type:'mid'}
          },
          home :{
            where:{type:'home'}
          },
          astrologer :{
            where:{type:'astrologer'}
          },
          orderAsc:{
            order: [
              ['position','asc'],
            ]
          },
        }
    });

    return Banner;
};