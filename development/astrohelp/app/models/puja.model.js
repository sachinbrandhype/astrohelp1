const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
var http = require('http');

module.exports = (sequelize, Sequelize) => {
    const Puja = sequelize.define('puja',{

      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      name_in_hindi:{
        type: Sequelize.STRING
      },
      name_in_gujrati:{
        type: Sequelize.STRING
      },
      // price: {
      //   type: Sequelize.FLOAT
      // },
      discount_type: {
        type: Sequelize.FLOAT
      },
      discount_price: {
        type: Sequelize.FLOAT
      },
      discount_comment: {
        type: Sequelize.STRING
      },
      position: {
        type: Sequelize.INTEGER
      },
      image: {
        type: Sequelize.STRING
      },
      ledger_code_id:{
        type: Sequelize.INTEGER
      },
      status: {
        type: Sequelize.INTEGER
      },
      pooja_type: {
        type: Sequelize.INTEGER
      },
      added_on: {
        type: Sequelize.STRING
      },
      category_id: {
        type: Sequelize.STRING
      },
      gods: {
        type: Sequelize.STRING
      },
      temples: {
        type: Sequelize.STRING
      },
      description: {
        type: Sequelize.TEXT
      },
      desc_in_hindi:{
        type: Sequelize.TEXT
      },
      desc_in_gujrati	:{
        type: Sequelize.TEXT
      },
      images: {
        type: Sequelize.STRING
      },
      booking_cut_of_hour:{
        type: Sequelize.STRING
      },
      reschedule_cut_of_hour:{
        type: Sequelize.STRING
      },
      base_price:{
        type: Sequelize.FLOAT
      },
      tax_percentage:{
        type: Sequelize.INTEGER
      },
      discountdescription:{
        type: Sequelize.STRING
      },
      imageUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.puja}${this.image}`;
          }
      },
      share_url: {
        type: DataTypes.VIRTUAL,
        get() {
          return `${imagePaths.share_puja}${this.id}`;
        }
    },
      price: {
        type: DataTypes.VIRTUAL,
        get() {
          var price = parseFloat(this.base_price);
          if(price<=0){
            return 0 ;
          }else{
            var tax = parseInt(this.tax_percentage);
            var discount_price = this.discount_price ? parseInt(this.discount_price) : 0;
            price -= discount_price
            if(tax){
              var tax_price =parseFloat((price)*(tax/100))
              return price + tax_price;
            }else{
              return price;
  
            }
          }
        
        }
      },

      tax_price: {
        type: DataTypes.VIRTUAL,
        get() {
          var price = parseFloat(this.base_price);
          if(price<=0){
            return 0 ;
          }else{
            var tax = parseInt(this.tax_percentage);
            var discount_price = this.discount_price ? parseInt(this.discount_price) : 0;
            price -= discount_price
            if(tax){
              var tax_price =((price)*(tax/100))
              return (tax_price)
            }else{
              return 0;
  
            }
          }
        
        }
      },
    },{
        tableName: 'puja',
        timestamps: false,
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

    return Puja;
};
