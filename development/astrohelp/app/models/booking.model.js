const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const booking = sequelize.define("bookings", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      orderID:{
        type: DataTypes.STRING
      },
      type: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      booking_type: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      puja_type: {
        type: DataTypes.STRING
      },
      assign_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      subtotal: {
        type: DataTypes.FLOAT
      },
      discount: {
        type: DataTypes.FLOAT
      },
      coupon_discount: {
        type: DataTypes.FLOAT
      },
      gst: {
        type: DataTypes.FLOAT
      },
      donation: {
        type: DataTypes.FLOAT
      },
      payable_amount: {
        type: DataTypes.FLOAT
      },
      wallet_deduct:{
        type: DataTypes.FLOAT

      },
      coupon_id: {
        type: DataTypes.INTEGER
      },
      coupon_code: {
        type: DataTypes.STRING
      },
      uploads_doc: {
        type: DataTypes.STRING
      },
      booking_for: {
        type: DataTypes.STRING
      },
      user_name: {
        type: DataTypes.STRING
      },
      user_phone: {
        type: DataTypes.STRING
      },
      user_email: {
        type: DataTypes.STRING
      },
      user_gender: {
        type: DataTypes.STRING
      },
      ended_by:{
        type: DataTypes.STRING
      },
      hangup_cause:{
        type: DataTypes.STRING
      },
      ivr_recording:{
        type: DataTypes.STRING

      },
      user_dob: {
        type: DataTypes.STRING
      },
      user_tob: {
        type: DataTypes.STRING
      },
      user_pob: {
        type: DataTypes.STRING
      },
      user_fathername: {
        type: DataTypes.STRING
      },
      user_mothername: {
        type: DataTypes.STRING
      },
      user_gotro: {
        type: DataTypes.STRING
      },
      user_spouse: {
        type: DataTypes.STRING
      },
      language: {
        type: DataTypes.STRING
      },
      member_id: {
        type: DataTypes.INTEGER
      },
      message: {
        type: DataTypes.TEXT
      },
      schedule_date: {
        type: DataTypes.DATE
      },
      schedule_time: {
        type: DataTypes.STRING
      },
      schedule_date_time : {
        type: DataTypes.DATE

      },
      start_time: {
        type: DataTypes.DATE
      },
      end_time: {
        type: DataTypes.DATE
      },
      total_minutes: {
        type: DataTypes.INTEGER
      },
    
      payment_mode: {
        type: DataTypes.STRING
      },
      status: {
        type: DataTypes.INTEGER
      },
      is_chat_or_video_start:{
        type:DataTypes.INTEGER
      },
      cancel_by_id: {
        type: DataTypes.INTEGER
      },
      cancel_by: {
        type: DataTypes.INTEGER
      },
      is_paid: {
        type: DataTypes.INTEGER
      },
      is_premium: {
        type: DataTypes.INTEGER
      },
      txn_id: {
        type: DataTypes.STRING
      },
      bridge_id:{
        type: DataTypes.STRING
      },
      refund_txn_id: {
        type: DataTypes.INTEGER
      },
      time_minutes:{
        type: DataTypes.STRING
      },
      total_seconds:{
        type: DataTypes.INTEGER
      },
      created_at: {
        type: DataTypes.DATE
      },
      updated_at: {
        type: DataTypes.DATE
      },

      broadcast_id: {
        type: DataTypes.INTEGER
      },
      horoscope_name:{
        type: DataTypes.STRING

      },
      latitude:{
        type: DataTypes.STRING

      },
      longitude:{
        type: DataTypes.STRING
      },
      astrologer_comission_perct:{
        type: DataTypes.INTEGER
      },
      astrologer_comission_amount:{
        type: DataTypes.FLOAT
      },
      refund_request_raised:{
        type: DataTypes.INTEGER
      },
      refund_request_on:{
        type: DataTypes.DATE
      },
      refund_request_reason:{
        type: DataTypes.STRING
      },
      horoscope_message:{
        type: DataTypes.TEXT
      },

      gst_astro:{
        type: DataTypes.FLOAT
      },
      tds_astro:{
        type: DataTypes.FLOAT
      },
      total_astro_comission :{
        type: DataTypes.FLOAT
      },
      ivr_unique_id:{
        type: DataTypes.STRING

      },
      // is_accepted: {
      //   type: DataTypes.VIRTUAL,
      //   get() {
      //     if(this.status == 6){
      //       return 1
      //     }else{
      //       return 0
      //     }
        
      //   }
      // },

      horoscopeUrl: {
        type: DataTypes.VIRTUAL,
        get() {
          if(this.uploads_doc != '' && this.uploads_doc){
            var str = this.uploads_doc.split(",");

            return imagePaths.horoscope_matching+(str[0] ? str[0]  : '' )
          }else{
            return ''
          }
        
        }
      },
      price_per_mint: {
        type: DataTypes.FLOAT,
      },

      orderID: {
        type: DataTypes.VIRTUAL,
        get() {
            return this.id;
        }
      },

      invoiceURL: {
            type: DataTypes.VIRTUAL,
            get() {
                return imagePaths.astrologerInvoice+this.id;
            }
        },
        is_confirmed:{
          type: DataTypes.INTEGER
        }
    },{
        timestamps: false,
        tableName: 'bookings',
        scopes:{
          puja:{
            where:{booking_type:1}
          },
          astrologer:{
            where:{booking_type:2}
          },
          // broadcast:{
          //   where:{}
          // }
          // main:{
          //   where:{type:'main'}
          // },
          // mid:{
          //   where:{type:'mid'}
          // },
          orderDesc:{
            order: [
              ['id','desc'],
            ]
          },
          orderAsc:{
            order: [
              ['id','asc'],
            ]
          },
        }
    });

    return booking;
};