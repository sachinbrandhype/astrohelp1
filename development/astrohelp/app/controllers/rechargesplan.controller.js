const { successRes, failedRes } = require("../helpers/response.helper");
const { WalletPlan } = require("../models")

const get_recharge_plans = async (req,res) => {
    const data = await WalletPlan.scope(['orderAsc']).findAll({
        where:{
            status:1
        }
    });
    data ? res.json(successRes('',data)) : res.json(failedRes('',data))

}


module.exports = {
    get_recharge_plans
}