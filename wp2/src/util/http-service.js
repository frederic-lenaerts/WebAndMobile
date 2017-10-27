import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.2.250';

    getAllStatus() {
        return axios.get( `${ this.baseUrl }/status/` ).then( r => r.data );
    }

    getAllLocations() {
        return axios.get( `${ this.baseUrl }/location/` ).then( r => r.data );
    }

    addCalorieEntry( date, calories, id ) {
        return axios.post( `${ this.baseUrl }/calorieEntries`, { id: id, userId: this.userId, date: date, weight: calories });
    }
    deleteCalorieEntry( id ) {
        return axios.delete(`${this.baseUrl}/calorieEntries/${id}`)
    }
}

const httpService = new HttpService();

export default httpService;
