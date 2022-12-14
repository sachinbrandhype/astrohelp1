const { cancel_call_audio } = require("../controllers/tatatele.controller");
const { makeRequest } = require("./axios.helper")
const { Booking, Astrologer } = require('../models/index')
const axios = require("axios").default;

const get_tatatele_token = async (req, res) => {
    const options = {
        method: 'POST',
        url: 'https://api-smartflo.tatateleservices.com/v1/auth/login',
        headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
        data: { email: 'astro.help', password: 'Astro@8888' }
    };

    const data = await axios.request(options).then(function (response) {
        console.log(response.data);
        return response.data.success ? response.data.access_token : false

    }).catch(function (error) {
        console.error(error);
        return false
    });
    return data;
}


const make_call_ivr = async (astrologer_id, user_id, price_per_mint) => {

    const data = {
        user_id: user_id,
        astrologer_id: astrologer_id,
        price_per_mint: price_per_mint,
        type: 2
    }
    // const bkg = await Booki
    try {
        const daata = await makeRequest('POST', 'https://astrohelp24.com/ivrapi/makecallSD', {}, data);
        console.log(data);
        return daata;
    } catch (error) {
        return error;

    }


}

const HangupcallApi = async (booking_id) => {

    const data = {
        booking_id: booking_id
    }
    try {
        // const daata =await makeRequest('POST','https://astrohelp24.com/ivrapi/HangupcallApi',{},data);
        const daata = await cancel_call_audio(booking_id);
        console.log(data);
        return daata;
    } catch (error) {
        return error;

    }


}


const call_reminder_ivr = async (astrologer_id) => {

    // const data = {
    //     astrologer_id:astrologer_id
    // }

    try {
        const token = await get_tatatele_token();

        const astrologerd = await Astrologer.findOne({
            where: {
                id: astrologer_id
            }
        });
        if (astrologerd) {
            const options = {
                method: 'POST',
                url: 'https://api-smartflo.tatateleservices.com/v1/broadcast/lead/106422',
                headers: { Accept: 'application/json', 'Content-Type': 'application/json', Authorization: token },
                data: {
                    field_0: astrologerd.phone,
                    duplicate_option: "clone"
                }
            };
            await axios.request(options)
        }

    } catch (error) {

    }



    // makeRequest('POST','https://astrohelp24.com/ivrapi/makecallrecording',{},data);
    return true;
}

module.exports = {
    make_call_ivr,
    call_reminder_ivr,
    HangupcallApi
}