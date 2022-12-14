const { fetchUserByID, currentTimeStamp } = require("../helpers/user.helper");
const { sequelize, Transaction, User, Setting, WalletPlan,Cashfreetransaction } = require("../models");

const moment = require("moment");
const { failedRes, successRes } = require("../helpers/response.helper");


const fetch_payable_amount_wallet = async (req,res) => {
  const {user_id,amount}=req.body;
  var gst_perct = 18

  const settings =await Setting.findOne()
  if(settings){
    gst_perct =parseInt(settings.gst_prct_for_wallet);
  }

  const gst_amount = (parseFloat(amount)*(gst_perct/100));

  const total_amount = amount + gst_amount;

  return res.json({
    status:true,
    gst_perct,
    gst_amount,
    recharge_amount:amount,
    total_amount
  })
}

const recharge_user_wallet = async (req,res) => {
    const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json} = req.body;
    console.log('====================================');
    console.log(req.body);
    console.log('====================================');
    const amount =parseFloat(recharge_amount);
    const user = await fetchUserByID(user_id);
    if(!user) { return res.json(failedRes('user not found')) }
    var old_wallet = parseFloat(user.wallet);
    var txn_amount =  parseFloat(amount);
    var payment = txn_amount+parseFloat(gst_amount);
    var txn_name = "Recharge Wallet";
    if(first_user && amount == 1){
      txn_amount = 100;
      txn_name = "Complimentary First Recharge"
    }
    var json_dt=null;
    if(json){
      json_dt=(json)
    }

    var new_wallet = old_wallet+txn_amount;
    var txn_type = 'credit';
    const dateTime = currentTimeStamp();
    var transactiondata = {
      user_id:user_id,
      txn_name:txn_name,
      payment_mode:'online',
      booking_txn_id:txn_id,
      txn_for:'wallet',
      type:txn_type,
      old_wallet:old_wallet,
      txn_amount:txn_amount,
      update_wallet:new_wallet,
      status:1,
      created_at:dateTime,
      updated_at:dateTime,
      gst_perct,
      gst_amount,
      payment,
      json:json_dt
    };
    const t = await sequelize.transaction();
    try {
      await User.update({
        wallet:new_wallet
      },{
        where:{
          id:user_id
        }
      },  { transaction: t })
      const dt = await Transaction.create(transactiondata
        , { transaction: t });
      await t.commit();
      return res.json(successRes('done!!',dt))
    }catch (error) {
      // If the execution reaches this line, an error was thrown.
      // We rollback the transaction.
      await t.rollback();
      return res.json(failedRes('failed!!'));
    }
  
}


const recharge_user_wallet_new = async (req,res) => {
  const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json} = req.body;
  console.log('====================================');
  console.log(req.body);
  console.log('====================================');
  const amount =parseFloat(recharge_amount);
  const user = await fetchUserByID(user_id);
  if(!user) { return res.json(failedRes('user not found')) }
  var old_wallet = parseFloat(user.wallet);
  var txn_amount =  parseFloat(amount);
  var payment = txn_amount+parseFloat(gst_amount);
  var txn_name = "Recharge Wallet";
  if(first_user && amount == 1){
    txn_amount = 100;
    txn_name = "Complimentary First Recharge"
  }
  var json_dt=null;
  if(json){
    json_dt=(json)
  }

  var new_wallet = old_wallet+txn_amount;
  var txn_type = 'credit';
  const dateTime = currentTimeStamp();
  var transactiondata = {
    user_id:user_id,
    txn_name:txn_name,
    payment_mode:'online',
    booking_txn_id:txn_id,
    txn_for:'wallet',
    type:txn_type,
    old_wallet:old_wallet,
    txn_amount:txn_amount,
    update_wallet:new_wallet,
    status:1,
    created_at:dateTime,
    updated_at:dateTime,
    gst_perct,
    gst_amount,
    payment,
    json:json_dt
  };
  const t = await sequelize.transaction();
  try {
    await User.update({
      wallet:new_wallet
    },{
      where:{
        id:user_id
      }
    },  { transaction: t })
    const dt = await Transaction.create(transactiondata
      , { transaction: t });
    await t.commit();
    return res.json(successRes('done!!',dt))
  }catch (error) {
    // If the execution reaches this line, an error was thrown.
    // We rollback the transaction.
    await t.rollback();
    return res.json(failedRes('failed!!'));
  }

}




// const recharge_user_wallet_v2 = async (req,res) => {
//   const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json,plan_id} = req.body;
//   console.log('====================================');
//   console.log(req.body);
//   console.log('====================================');
//   const amount =parseFloat(recharge_amount);
//   const user = await fetchUserByID(user_id);
//   if(!user) { return res.json(failedRes('user not found')) }
//   var old_wallet = parseFloat(user.wallet);
//   var txn_amount =  parseFloat(amount);
//   var payment =0;
//   var plan_amount = txn_amount;
//   var txn_name = "Recharge Wallet";

//   if(plan_id){
//     const planewallet = await WalletPlan.findOne({
//       where:{
//         id:plan_id
//       }
//     })
//     if(planewallet){
//       payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
//       plan_amount = planewallet.recharge;
//       txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit

//     }else{
//       payment = txn_amount+parseFloat(gst_amount);
//     }
//   }else{
//     payment = txn_amount+parseFloat(gst_amount);
//   }

  
//   if(first_user){
//     // txn_amount = 100;
//     txn_name = "Complimentary First Recharge"
//   }

//   var json_dt=null;
//   if(json){
//     json_dt=(json)
//   }

//   var new_wallet = old_wallet+txn_amount;
//   var txn_type = 'credit';
//   const dateTime = currentTimeStamp();
//   var transactiondata = {
//     user_id:user_id,
//     txn_name:txn_name,
//     payment_mode:'online',
//     booking_txn_id:txn_id,
//     txn_for:'wallet',
//     type:txn_type,
//     old_wallet:old_wallet,
//     txn_amount:txn_amount,
//     update_wallet:new_wallet,
//     status:1,
//     created_at:dateTime,
//     updated_at:dateTime,
//     gst_perct,
//     gst_amount,
//     payment,
//     json:json_dt,
//     plan_amount
//   };
//   const t = await sequelize.transaction();
//   try {
//     await User.update({
//       wallet:new_wallet
//     },{
//       where:{
//         id:user_id
//       }
//     },  { transaction: t })
//     const dt = await Transaction.create(transactiondata
//       , { transaction: t });
//     await t.commit();
//     return res.json(successRes('done!!',dt))
//   }catch (error) {
//     // If the execution reaches this line, an error was thrown.
//     // We rollback the transaction.
//     await t.rollback();
//     return res.json(failedRes('failed!!'));
//   }

// }



const recharge_user_wallet_v2 = async (req,res) => {
  const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json,plan_id} = req.body;
  await delay(1000)
  return res.json(successRes('done!!'))
  console.log('====================================');
  console.log(req.body);
  console.log('====================================');
  const amount =parseFloat(recharge_amount);
  const user = await fetchUserByID(user_id);
  if(!user) { return res.json(failedRes('user not found')) }
  var old_wallet = parseFloat(user.wallet);
  var txn_amount =  parseFloat(amount);
  var payment =0;
  var plan_amount = txn_amount;
  var txn_name = "Recharge Wallet";

  if(plan_id){
    const planewallet = await WalletPlan.findOne({
      where:{
        id:plan_id
      }
    })
    if(planewallet){
      payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
      plan_amount = planewallet.recharge;
      txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit

    }else{
      payment = txn_amount+parseFloat(gst_amount);
    }
  }else{
    payment = txn_amount+parseFloat(gst_amount);
  }

  
  if(first_user){
    // txn_amount = 100;
    txn_name = "Complimentary First Recharge"
  }

  var json_dt=null;
  if(json){
    json_dt=(json)
  }

  const checkiftransactiondone = await Transaction.findOne({
    where:{
      booking_txn_id : txn_id

    }
  })

  if(!checkiftransactiondone){

    var new_wallet = old_wallet+txn_amount;
    var txn_type = 'credit';
    const dateTime = currentTimeStamp();
    var transactiondata = {
      user_id:user_id,
      txn_name:txn_name,
      payment_mode:'online',
      booking_txn_id:txn_id,
      txn_for:'wallet',
      type:txn_type,
      old_wallet:old_wallet,
      txn_amount:txn_amount,
      update_wallet:new_wallet,
      status:1,
      created_at:dateTime,
      updated_at:dateTime,
      gst_perct,
      gst_amount,
      payment,
      json:json_dt,
      plan_amount
    };
    const t = await sequelize.transaction();
    try {
      await User.update({
        wallet:new_wallet
      },{
        where:{
          id:user_id
        }
      },  { transaction: t })
      const dt = await Transaction.create(transactiondata
        , { transaction: t });
      await t.commit();
      return res.json(successRes('done!!',dt))
    }catch (error) {
      // If the execution reaches this line, an error was thrown.
      // We rollback the transaction.
      await t.rollback();
      return res.json(failedRes('failed!!'));
    }
  }else{
    res.json(failedRes('failed'))
  }

}







const recharge_user_wallet_v3 = async (req,res) => {
  const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json,plan_id} = req.body;
  //await delay(1000)
  //return res.json(successRes('done!!'))
  console.log('====================================');
  console.log(req.body);
  console.log('====================================');
  const amount =parseFloat(recharge_amount);
  const user = await fetchUserByID(user_id);
  if(!user) { return res.json(failedRes('user not found')) }
  var old_wallet = parseFloat(user.wallet);
  var txn_amount =  parseFloat(amount);
  var payment =0;
  var plan_amount = txn_amount;
  var txn_name = "Recharge Wallet";

  if(plan_id){
    const planewallet = await WalletPlan.findOne({
      where:{
        id:plan_id
      }
    })
    if(planewallet){
      payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
      plan_amount = planewallet.recharge;
      txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit

    }else{
      payment = txn_amount+parseFloat(gst_amount);
    }
  }else{
    payment = txn_amount+parseFloat(gst_amount);
  }

  
  if(first_user){
    // txn_amount = 100;
    txn_name = "Complimentary First Recharge"
  }

  var json_dt=null;
  if(json){
    json_dt=(json)
  }

  const checkiftransactiondone = await Transaction.findOne({
    where:{
      booking_txn_id : txn_id

    }
  })

  if(!checkiftransactiondone){

    var new_wallet = old_wallet+txn_amount;
    var txn_type = 'credit';
    const dateTime = currentTimeStamp();
    var transactiondata = {
      user_id:user_id,
      txn_name:txn_name,
      payment_mode:'online',
      booking_txn_id:txn_id,
      txn_for:'wallet',
      type:txn_type,
      old_wallet:old_wallet,
      txn_amount:txn_amount,
      update_wallet:new_wallet,
      status:1,
      created_at:dateTime,
      updated_at:dateTime,
      gst_perct,
      gst_amount,
      payment,
      json:json_dt,
      plan_amount
    };
    const t = await sequelize.transaction();
    try {
      await User.update({
        wallet:new_wallet
      },{
        where:{
          id:user_id
        }
      },  { transaction: t })
      const dt = await Transaction.create(transactiondata
        , { transaction: t });
      await t.commit();
      return res.json(successRes('done!!',dt))
    }catch (error) {
      // If the execution reaches this line, an error was thrown.
      // We rollback the transaction.
      await t.rollback();
      return res.json(failedRes('failed!!'));
    }
  }else{
    res.json(failedRes('failed'))
  }

}







const user_wallet_balance = async (req,res) => {
  const {user_id} = req.body;
  var plans = [];
  var cashback_perct=0;

  const user = await fetchUserByID(user_id);
   await Setting.findOne().then((st)=>{
    //  console.log(st);
    if(st){
      // console.log(st.rechargeplans);
        // var dt = JSON.parse(st.rechargeplans);
        // plans = dt.plans.split('|');
        // cashback_perct = dt.cashback_perct
        // console.log(dt);
    }
  })
  const wallet_balance = user.wallet ? user.wallet : 0;
  return res.json({
    status:true,
    wallet_balance,
    plans:[1000,2000,5000,8000],
    cashback_perct:5,
    data:user
  })
}



const wallet_history = async (req,res) => {
  const {user_id} = req.body;
  var {limit,offset}=req.body
  if(!limit){
    limit=10;
  }
  if(!offset){
    offset=0;
  }
  // console.log(user_id);

  // const user = await fetchUserByID(user_id);
  // const wallet_balance = user.wallet ? user.wallet : 0;
  const transactions =await Transaction.scope(['wallet','newest']).findAll({
    limit:parseInt(limit),
    offset:parseInt(offset),
    where:{
      user_id:user_id
    }
  });
  return res.json({
    status:true,
    // wallet_balance,
    data:transactions
  })
}


const check_if_first_recharge = async (req,res) => {
  const {user_id} = req.body;
  try {
    const transactiond = await Transaction.scope(['wallet']).findOne({
      where:{
        user_id:user_id
      }
    });
    if(!transactiond){
      res.json({
        status:true,
        message:'first recharge'
      })
    }else{
      res.json({
        status:false,
        message:''
      })
    }
  } catch (error) {
    res.json({
      status:false,
      message:''
    })
  }
 
}



const delay = ms => new Promise(resolve => setTimeout(resolve, ms))
const wallet_recharge_webhook_razorpay = async (req,res) => {
  console.log(req.body);

  const razorpaydata = req.body;
  const entity = razorpaydata.payload.payment.entity
  const txn_id = entity.id;
  const description1 = entity.description;

  const myArr = description1.split("|");
  if(myArr.length == 2){
    const description = myArr[0]

    const buff = new Buffer(description, 'base64');
    const jsonstring = buff.toString('ascii');
    const obj = JSON.parse(jsonstring)
  
    const {user_id,recharge_amount,gst_perct,gst_amount,first_user,json,plan_id} = obj;
    console.log('====================================');
    console.log(req.body);
    console.log('====================================');
  
    await delay(1000) 
  
    const checkiftransactiondone = await Transaction.findOne({
      where:{
        booking_txn_id : txn_id
  
      }
    })

    if(!checkiftransactiondone){

        const amount =parseFloat(recharge_amount);
        const user = await fetchUserByID(user_id);
        if(!user) { return res.json(failedRes('user not found')) }
        var old_wallet = parseFloat(user.wallet);
        var txn_amount =  parseFloat(amount);
        var payment =0;
        var plan_amount = txn_amount;
        var txn_name = "Recharge Wallet";
      
        if(plan_id){
          const planewallet = await WalletPlan.findOne({
            where:{
              id:plan_id
            }
          })
          if(planewallet){
            payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
            plan_amount = planewallet.recharge;
            txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit
      
          }else{
            payment = txn_amount+parseFloat(gst_amount);
          }
        }else{
          payment = txn_amount+parseFloat(gst_amount);
        }
      
        
        if(first_user){
          // txn_amount = 100;
          txn_name = "Complimentary First Recharge"
        }
      
        var json_dt=null;
        if(json){
          json_dt=(json)
        }

        if(txn_name == 'Complimentary First Recharge'){
          const checkfirstrecharge = await Transaction.findOne({
            where:{
              txn_name : 'Complimentary First Recharge',
              user_id:user_id
        
            }
          })
          if(checkfirstrecharge){
            return failedRes('failed!!');

          }

        }
      
        var new_wallet = old_wallet+txn_amount;
        var txn_type = 'credit';
        const dateTime = currentTimeStamp();
        var transactiondata = {
          user_id:user_id,
          txn_name:txn_name,
          payment_mode:'online',
          booking_txn_id:txn_id,
          txn_for:'wallet',
          type:txn_type,
          old_wallet:old_wallet,
          txn_amount:txn_amount,
          update_wallet:new_wallet,
          status:1,
          created_at:dateTime,
          updated_at:dateTime,
          gst_perct,
          gst_amount,
          payment,
          json:json_dt,
          plan_amount
        };
        const t = await sequelize.transaction();
        try {
          await User.update({
            wallet:new_wallet
          },{
            where:{
              id:user_id
            }
          },  { transaction: t })
          const dt = await Transaction.create(transactiondata
            , { transaction: t });
          await t.commit();
          return res.json(successRes('done!!',dt))
        }catch (error) {
          // If the execution reaches this line, an error was thrown.
          // We rollback the transaction.
          await t.rollback();
          return res.json(failedRes('failed!!'));
        }
      
      }
    }

    res.json(failedRes(''))
  

}




const notifyurl_cashfree = async (req,res) => {
  await delay(1000) 

  const order_id = req.body.orderId
  const txnstatus = req.body.txStatus
  console.log("=============================================")
  console.log(JSON.stringify(req.body))
  console.log("=============================================")
  if(order_id && txnstatus == 'SUCCESS'){
    const check = await Cashfreetransaction.findOne({
      where:{
        order_id:order_id
      }
    });
    if(check){

      const data = JSON.parse(check.jsondata)
      const txn_id = order_id;
      const {user_id,recharge_amount,gst_perct,gst_amount,first_user,json,plan_id} = data;
      const checkiftransactiondone = await Transaction.findOne({
        where:{
          booking_txn_id : txn_id
    
        }
      })
  
      if(!checkiftransactiondone){
        const amount =parseFloat(recharge_amount);
        const user = await fetchUserByID(user_id);
        if(!user) { return res.json(failedRes('user not found')) }
        var old_wallet = parseFloat(user.wallet);
        var txn_amount =  parseFloat(amount);
        var payment =0;
        var plan_amount = txn_amount;
        var txn_name = "Recharge Wallet";
      
        if(plan_id){
          const planewallet = await WalletPlan.findOne({
            where:{
              id:plan_id
            }
          })
          if(planewallet){
            payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
            plan_amount = planewallet.recharge;
            txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit
      
          }else{
            payment = txn_amount+parseFloat(gst_amount);
          }
        }else{
          payment = txn_amount+parseFloat(gst_amount);
        }
      
        
        if(first_user){
          // txn_amount = 100;
          txn_name = "Complimentary First Recharge"
        }
      
        var json_dt=null;
        // if(json){
        //   json_dt=(json)
        // }
        json_dt = JSON.stringify(req.body)
      
        var new_wallet = old_wallet+txn_amount;
        var txn_type = 'credit';
        const dateTime = currentTimeStamp();
        var transactiondata = {
          user_id:user_id,
          txn_name:txn_name,
          payment_mode:'online',
          booking_txn_id:txn_id,
          txn_for:'wallet',
          type:txn_type,
          old_wallet:old_wallet,
          txn_amount:txn_amount,
          update_wallet:new_wallet,
          status:1,
          created_at:dateTime,
          updated_at:dateTime,
          gst_perct,
          gst_amount,
          payment,
          json:json_dt,
          plan_amount
        };

        if(txn_name == 'Complimentary First Recharge'){
          const checkfirstrecharge = await Transaction.findOne({
            where:{
              txn_name : 'Complimentary First Recharge',
              user_id:user_id
        
            }
          })
          if(checkfirstrecharge){
            return failedRes('failed!!');

          }

        }

          const t = await sequelize.transaction();
          try {
            await User.update({
              wallet:new_wallet
            },{
              where:{
                id:user_id
              }
            },  { transaction: t })
            const dt = await Transaction.create(transactiondata
              , { transaction: t });
            await t.commit();
            return res.json(successRes('done!!',dt))
          }catch (error) {
            // If the execution reaches this line, an error was thrown.
            // We rollback the transaction.
            await t.rollback();
            return res.json(failedRes('failed!!'));
          }
        
      }
    }
  }
  

}


const get_cashfree_orderid = async (req,res) => {
  const {user_id} = req.body;
  const dateTime = currentTimeStamp();
  const order_id = 'cf'+moment().utc()+user_id;
  
  const storedata = {
    user_id,
    order_id:order_id,
    jsondata:JSON.stringify(req.body),
    created_at:dateTime,
  }
  await Cashfreetransaction.create(storedata)
  .then( async (rs)=>{
    res.json({
      status:true,
      order_id:order_id
    })
  })
  .catch((err)=>{
    res.json({
      status:false,
      message:"something went wrong!"
    })

  })
}




const recharge_by_juspay = async (req,res) => {
  const {user_id,recharge_amount,txn_id,gst_perct,gst_amount,first_user,json,plan_id} = req.body;
  await delay(1000)
  // return res.json(successRes('done!!'))
  console.log('====================================');
  console.log(req.body);
  console.log('====================================');
  const amount =parseFloat(recharge_amount);
  const user = await fetchUserByID(user_id);
  if(!user) { return res.json(failedRes('user not found')) }
  var old_wallet = parseFloat(user.wallet);
  var txn_amount =  parseFloat(amount);
  var payment =0;
  var plan_amount = txn_amount;
  var txn_name = "Recharge Wallet";

  if(plan_id){
    const planewallet = await WalletPlan.findOne({
      where:{
        id:plan_id
      }
    })
    if(planewallet){
      payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
      plan_amount = planewallet.recharge;
      txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit

    }else{
      payment = txn_amount+parseFloat(gst_amount);
    }
  }else{
    payment = txn_amount+parseFloat(gst_amount);
  }

  
  if(first_user){
    // txn_amount = 100;
    txn_name = "Complimentary First Recharge"
  }

  var json_dt=null;
  if(json){
    json_dt=(json)
  }

  const checkiftransactiondone = await Transaction.findOne({
    where:{
      booking_txn_id : txn_id

    }
  })

  if(!checkiftransactiondone){

    var new_wallet = old_wallet+txn_amount;
    var txn_type = 'credit';
    const dateTime = currentTimeStamp();
    var transactiondata = {
      user_id:user_id,
      txn_name:txn_name,
      payment_mode:'online',
      booking_txn_id:txn_id,
      txn_for:'wallet',
      type:txn_type,
      old_wallet:old_wallet,
      txn_amount:txn_amount,
      update_wallet:new_wallet,
      status:1,
      created_at:dateTime,
      updated_at:dateTime,
      gst_perct,
      gst_amount,
      payment,
      json:json_dt,
      plan_amount
    };
    const t = await sequelize.transaction();
    try {
      await User.update({
        wallet:new_wallet
      },{
        where:{
          id:user_id
        }
      },  { transaction: t })
      const dt = await Transaction.create(transactiondata
        , { transaction: t });
      await t.commit();
      return res.json(successRes('done!!',dt))
    }catch (error) {
      // If the execution reaches this line, an error was thrown.
      // We rollback the transaction.
      await t.rollback();
      return res.json(failedRes('failed!!'));
    }
  }else{
    res.json(failedRes('failed'))
  }

}





const recharge_by_juspay_webhook = async (req,res) => {
  console.log('---------------------------------------------------jupsay---------------------------------------',req.body);
  // console.log();
  await delay(500) 
  const {id,date_created} = req.body;
  const order = req.body.content.order;
  const {order_id,customer_id,customer_email,currency,status} = order;
  const pg_resp = order.payment_gateway_response;
  // if(customer_id == 1){

    if(order_id && status == 'CHARGED'){
      const check = await Cashfreetransaction.findOne({
        where:{
          order_id:order_id,
          // amount:order.amount,
          user_id:customer_id,
          status:0
        }
      });

      if(check){
        const data = JSON.parse(check.jsondata)
        const txn_id = order_id;
        const user_id = customer_id;
        const {recharge_amount,gst_perct,gst_amount,json,plan_id} = data;
        var {first_user} = data;
        const checkiftransactiondone = await Transaction.findOne({
          where:{
            booking_txn_id : txn_id
      
          }
        })
    
        if(!checkiftransactiondone){
          const amount =parseFloat(recharge_amount);
          const user = await fetchUserByID(user_id);
          if(!user) { return res.json(failedRes('user not found')) }
          var old_wallet = parseFloat(user.wallet);
          var txn_amount =  parseFloat(amount);
          var payment =0;
          var plan_amount = txn_amount;
          var txn_name = "Recharge Wallet";
          

         
        
          if(plan_id){
            const planewallet = await WalletPlan.findOne({
              where:{
                id:plan_id
              }
            })
            if(planewallet){
              payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
              plan_amount = planewallet.recharge;
              txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit
              if(planewallet.for_new_user){
                first_user = true;
              }

              // if(txn_name == 'Complimentary First Recharge'){
              //   const checkfirstrecharge = await Transaction.findOne({
              //     where:{
              //       txn_name : 'Complimentary First Recharge',
              //       user_id:user_id
              
              //     }
              //   })
              //   if(checkfirstrecharge){
              //     return failedRes('failed!!');
      
              //   }
      
              // }
        
            }else{
              first_user=false;
              payment = txn_amount+parseFloat(gst_amount);
            }
          }else{
            first_user = false;
            payment = txn_amount+parseFloat(gst_amount);
          }

          if(first_user){
            // txn_amount = 100;
            txn_name = "Complimentary First Recharge"
          }
        
          
         
        
          var json_dt=null;
          // if(json){
          //   json_dt=(json)
          // }
          json_dt = JSON.stringify(req.body)
        
          var new_wallet = old_wallet+txn_amount;
          var txn_type = 'credit';
          const dateTime = currentTimeStamp();
          var transactiondata = {
            user_id:user_id,
            txn_name:txn_name,
            payment_mode:'online',
            booking_txn_id:txn_id,
            txn_for:'wallet',
            type:txn_type,
            old_wallet:old_wallet,
            txn_amount:txn_amount,
            update_wallet:new_wallet,
            status:1,
            created_at:dateTime,
            updated_at:dateTime,
            gst_perct,
            gst_amount,
            payment,
            json:json_dt,
            bank_txn_id:order.id,
            pg_txn_id:pg_resp.txn_id,
            txn_mode:order.payment_method,
            plan_amount
          };
  
          if(txn_name == 'Complimentary First Recharge'){
            const checkfirstrecharge = await Transaction.findOne({
              where:{
                txn_name : 'Complimentary First Recharge',
                user_id:user_id
          
              }
            })
            if(checkfirstrecharge){
              return failedRes('failed!!');
  
            }
  
          }
  
            const t = await sequelize.transaction();
            try {
              await User.update({
                wallet:new_wallet
              },{
                where:{
                  id:user_id
                }
              },  { transaction: t })
              const dt = await Transaction.create(transactiondata
                , { transaction: t });
              await t.commit();
              Cashfreetransaction.update({
                status:1
              },{
                where:{id:check.id}
              })
              return res.json(successRes('done!!',dt))
            }catch (error) {
              // If the execution reaches this line, an error was thrown.
              // We rollback the transaction.
              await t.rollback();
              return res.json(failedRes('failed!!'));
            }
          
        }
      }else{
        return res.json(failedRes('no txns!'))
      }
    }
  // }

 

  
  

}



// const recharge_by_juspay = async (req,res) => {
//   await delay(1000) 
//   return res.json(successRes(''));

//   const order_id = req.body.orderId
//   const txnstatus = req.body.txStatus

//   if(order_id && txnstatus == 'SUCCESS'){
//     const check = await Cashfreetransaction.findOne({
//       where:{
//         order_id:order_id
//       }
//     });
//     if(check){

//       const data = JSON.parse(check.jsondata)
//       const txn_id = order_id;
//       const {user_id,recharge_amount,gst_perct,gst_amount,first_user,json,plan_id} = data;
//       const checkiftransactiondone = await Transaction.findOne({
//         where:{
//           booking_txn_id : txn_id
    
//         }
//       })
  
//       if(!checkiftransactiondone){
//         const amount =parseFloat(recharge_amount);
//         const user = await fetchUserByID(user_id);
//         if(!user) { return res.json(failedRes('user not found')) }
//         var old_wallet = parseFloat(user.wallet);
//         var txn_amount =  parseFloat(amount);
//         var payment =0;
//         var plan_amount = txn_amount;
//         var txn_name = "Recharge Wallet";
      
//         if(plan_id){
//           const planewallet = await WalletPlan.findOne({
//             where:{
//               id:plan_id
//             }
//           })
//           if(planewallet){
//             payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
//             plan_amount = planewallet.recharge;
//             txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit
      
//           }else{
//             payment = txn_amount+parseFloat(gst_amount);
//           }
//         }else{
//           payment = txn_amount+parseFloat(gst_amount);
//         }
      
        
//         if(first_user){
//           // txn_amount = 100;
//           txn_name = "Complimentary First Recharge"
//         }
      
//         var json_dt=null;
//         // if(json){
//         //   json_dt=(json)
//         // }
//         json_dt = JSON.stringify(req.body)
      
//         var new_wallet = old_wallet+txn_amount;
//         var txn_type = 'credit';
//         const dateTime = currentTimeStamp();
//         var transactiondata = {
//           user_id:user_id,
//           txn_name:txn_name,
//           payment_mode:'online',
//           booking_txn_id:txn_id,
//           txn_for:'wallet',
//           type:txn_type,
//           old_wallet:old_wallet,
//           txn_amount:txn_amount,
//           update_wallet:new_wallet,
//           status:1,
//           created_at:dateTime,
//           updated_at:dateTime,
//           gst_perct,
//           gst_amount,
//           payment,
//           json:json_dt,
//           plan_amount
//         };

//         if(txn_name == 'Complimentary First Recharge'){
//           const checkfirstrecharge = await Transaction.findOne({
//             where:{
//               txn_name : 'Complimentary First Recharge',
//               user_id:user_id
        
//             }
//           })
//           if(checkfirstrecharge){
//             return failedRes('failed!!');

//           }

//         }

//           const t = await sequelize.transaction();
//           try {
//             await User.update({
//               wallet:new_wallet
//             },{
//               where:{
//                 id:user_id
//               }
//             },  { transaction: t })
//             const dt = await Transaction.create(transactiondata
//               , { transaction: t });
//             await t.commit();
//             return res.json(successRes('done!!',dt))
//           }catch (error) {
//             // If the execution reaches this line, an error was thrown.
//             // We rollback the transaction.
//             await t.rollback();
//             return res.json(failedRes('failed!!'));
//           }
        
//       }
//     }
//   }
  

// }





const recharge_by_juspay_webhooknew = async (req,res) => {
  console.log('webhook hit',req.body);
  await delay(500) 
  const {id,date_created} = req.body;
  const order = req.body.content.order;
  const {order_id,customer_id,customer_email,currency,status} = order;
  const pg_resp = order.payment_gateway_response;
  // if(customer_id == 1){

    if(order_id && status == 'CHARGED'){
      const check = await Cashfreetransaction.findOne({
        where:{
          order_id:order_id,
          // amount:order.amount,
          user_id:customer_id,
          status:0
        }
      });

      if(check){
        const data = JSON.parse(check.jsondata)
        const txn_id = order_id;
        const user_id = customer_id;
        const {recharge_amount,gst_perct,gst_amount,json,plan_id} = data;
        var {first_user} = data;
        const checkiftransactiondone = await Transaction.findOne({
          where:{
            booking_txn_id : txn_id
      
          }
        })
    
        if(!checkiftransactiondone){
          const amount =parseFloat(recharge_amount);
          const user = await fetchUserByID(user_id);
          if(!user) { return res.json(failedRes('user not found')) }
          var old_wallet = parseFloat(user.wallet);
          var txn_amount =  parseFloat(amount);
          var payment =0;
          var plan_amount = txn_amount;
          var txn_name = "Recharge Wallet";
          

         
        
          if(plan_id){
            const planewallet = await WalletPlan.findOne({
              where:{
                id:plan_id
              }
            })
            if(planewallet){
              payment = parseFloat(planewallet.recharge)+parseFloat(gst_amount);
              plan_amount = planewallet.recharge;
              txn_name = "Wallet Recharge of Rs."+planewallet.recharge+' get Rs.'+planewallet.benefit
              if(planewallet.for_new_user){
                first_user = true;
              }

              // if(txn_name == 'Complimentary First Recharge'){
              //   const checkfirstrecharge = await Transaction.findOne({
              //     where:{
              //       txn_name : 'Complimentary First Recharge',
              //       user_id:user_id
              
              //     }
              //   })
              //   if(checkfirstrecharge){
              //     return failedRes('failed!!');
      
              //   }
      
              // }
        
            }else{
              first_user=false;
              payment = txn_amount+parseFloat(gst_amount);
            }
          }else{
            first_user = false;
            payment = txn_amount+parseFloat(gst_amount);
          }

          if(first_user){
            // txn_amount = 100;
            txn_name = "Complimentary First Recharge"
          }
        
          
         
        
          var json_dt=null;
          // if(json){
          //   json_dt=(json)
          // }
          json_dt = JSON.stringify(req.body)
        
          var new_wallet = old_wallet+txn_amount;
          var txn_type = 'credit';
          const dateTime = currentTimeStamp();
          var transactiondata = {
            user_id:user_id,
            txn_name:txn_name,
            payment_mode:'online',
            booking_txn_id:txn_id,
            txn_for:'wallet',
            type:txn_type,
            old_wallet:old_wallet,
            txn_amount:txn_amount,
            update_wallet:new_wallet,
            status:1,
            created_at:dateTime,
            updated_at:dateTime,
            gst_perct,
            gst_amount,
            payment,
            json:json_dt,
            bank_txn_id:order.id,
            pg_txn_id:pg_resp.txn_id,
            txn_mode:order.payment_method,
            plan_amount
          };
  
          if(txn_name == 'Complimentary First Recharge'){
            const checkfirstrecharge = await Transaction.findOne({
              where:{
                txn_name : 'Complimentary First Recharge',
                user_id:user_id
          
              }
            })
            if(checkfirstrecharge){
              return failedRes('failed!!');
  
            }
  
          }
  
            const t = await sequelize.transaction();
            try {
              await User.update({
                wallet:new_wallet
              },{
                where:{
                  id:user_id
                }
              },  { transaction: t })
              const dt = await Transaction.create(transactiondata
                , { transaction: t });
              await t.commit();
              Cashfreetransaction.update({
                status:1
              },{
                where:{id:check.id}
              })
              return res.json(successRes('done!!',dt))
            }catch (error) {
              // If the execution reaches this line, an error was thrown.
              // We rollback the transaction.
              await t.rollback();
              return res.json(failedRes('failed!!'));
            }
          
        }else{
          return res.json(failedRes('no txns!!'));

        }
      }
    }
  // }
}



module.exports = {
    recharge_user_wallet,
    wallet_history,
    user_wallet_balance,
    fetch_payable_amount_wallet,
    check_if_first_recharge,
    recharge_user_wallet_new,
    recharge_user_wallet_v2,
    recharge_user_wallet_v3,
    wallet_recharge_webhook_razorpay,
    notifyurl_cashfree,
    get_cashfree_orderid,
    recharge_by_juspay,
    recharge_by_juspay_webhook,
    recharge_by_juspay_webhooknew
};
