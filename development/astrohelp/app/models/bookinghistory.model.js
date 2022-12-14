const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const booking = sequelize.define("booking_history", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      suborderID: {
        type: Sequelize.STRING
      },
      mode: {
        type: Sequelize.STRING
      },
      user_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      booking_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      puja_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      assign_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      booking_started_by:{
        type: Sequelize.STRING
      },
      supervisor_id:{
        type: Sequelize.INTEGER.UNSIGNED

      },
      priest_id:{
        type: Sequelize.INTEGER.UNSIGNED

      },
      name: {
        type: Sequelize.STRING
      },
      tax_breakup:{
        type:Sequelize.TEXT
      },
    //   qty: {
    //     type: Sequelize.INTEGER.UNSIGNED
    //   },
      amount: {
        type: Sequelize.FLOAT
      },
      tax_percentage: {
        type: Sequelize.INTEGER
      },
      tax_amount: {
        type: Sequelize.FLOAT
      },
      tax_name: {
        type: Sequelize.STRING
      },
      host_type: {
        type: Sequelize.STRING
      },
      host_name: {
        type: Sequelize.STRING
      },
      host_dob: {
        type: Sequelize.STRING
      },
      host_tob: {
        type: Sequelize.STRING
      },
      host_pob: {
        type: Sequelize.STRING
      },
      host_mothername: {
        type: Sequelize.STRING
      },
      host_fathername: {
        type: Sequelize.STRING
      },
      host_gotro: {
        type: Sequelize.STRING
      },
      host_spouse: {
        type: Sequelize.STRING
      },
      member_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      guests: {
        type: Sequelize.TEXT
      },
      status: {
        type: Sequelize.INTEGER
      },

      created_at: {
        type: Sequelize.STRING
      },
      venue: {
        type: Sequelize.STRING
      },
      booking_location: {
        type: Sequelize.STRING
      },

      schedule_date: {
        type: Sequelize.STRING
      },
      schedule_time: {
        type: Sequelize.STRING
      },
      schedule_date_time	: {
        type: Sequelize.STRING

      },
      is_chat_or_video_start:{
        type:Sequelize.INTEGER
      },
      main_location_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      location_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      is_rescheduled:{
        type: Sequelize.INTEGER.UNSIGNED

      },

      bridge_id: {
        type: Sequelize.STRING
      },
      discount_amount:{
        type: Sequelize.FLOAT
      },

      complete_booking_date: {
        type: Sequelize.STRING
      },

      complete_booking_invoice: {
        type: Sequelize.STRING
      },

      cancel_invoice: {
        type: Sequelize.STRING
      },
      completed_certificate_file_path:{
        type: Sequelize.STRING
      },
      cancellation_percentage:{
        type: Sequelize.STRING

      },
      cancellation_datetime:{
        type: Sequelize.STRING

      },
      address:{
        type: Sequelize.STRING
      },
      city:{
        type: Sequelize.STRING
      },
      pincode:{
        type: Sequelize.STRING
      },
      message:{
        type: Sequelize.STRING
      },
      cancellation_amount:{
        type: Sequelize.FLOAT

      },
      refund_amount:{
        type: Sequelize.FLOAT

      },
      unit_price:{
        type: Sequelize.FLOAT

      },
      completeInvoiceURL: {
          type: DataTypes.VIRTUAL,
          get() {
            if (this.status == 1) {
              return imagePaths.invoiceURL+this.booking_id;
              
            }else{
              return imagePaths.poinvoiceUrl+this.booking_id;

            }
          }
      },
      cancelInvoiceURL: {
          type: DataTypes.VIRTUAL,
          get() {
            if(this.status == 2){
              return imagePaths.cancel_invoice+this.booking_id;
  
            }else{
              return imagePaths.cancel_invoice2+this.cancel_invoice;
              
            }
          }
      }
      ,
      share_url: {
        type: DataTypes.VIRTUAL,
        get() {
            return 'http://139.59.25.187/pooja-details/'+this.puja_id;
        }
    },

    certificate_url: {
        type: DataTypes.VIRTUAL,
        get() {
          if(this.status == 1 ){
            // return imagePaths.certificateURL+'id='+this.id+'&booking_id='+this.booking_id;;
            return this.completed_certificate_file_path;
          }else{
            return '';
          }
        }
    }
    ,

      suborderID: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${this.id}`;
          }
      }
    },{
        timestamps: false,
        tableName: 'booking_history',
        // scopes:{
        //   active:{
        //     where:{is_active:1}
        //   },
        //   main:{
        //     where:{type:'main'}
        //   },
        //   mid:{
        //     where:{type:'mid'}
        //   },
        //   orderAsc:{
        //     order: [
        //       ['position','asc'],
        //     ]
        //   },
        // }
    });

    return booking;
};