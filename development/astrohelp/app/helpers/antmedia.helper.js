const { makeRequest } = require("./axios.helper");

const API_BASE_URL = 'https://astrohelp24.com:5443/LiveApp/rest/v2/';
const delete_broadcast_ant_media = async (roomId,stramId) => {
    // const end_point = `broadcasts/conference-rooms/${roomId}/delete`;
    const end_point = `broadcasts/${stramId}`;

    const URL = API_BASE_URL+end_point;
   const res=await makeRequest('DELETE',URL)
   console.log('====================================');
   console.log('delete_broadcast_ant_media '+URL,res.data);
   console.log('====================================');
}
module.exports = {
    delete_broadcast_ant_media
}