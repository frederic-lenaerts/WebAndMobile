import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.2.250/wp1/';

    getAllStatus() {
        return axios.get( `${ this.baseUrl }status/` ).then( r => r.data );
    }

    addStatusEntry( status ) {
        return axios.post( `${ this.baseUrl }status/`, status, { 'Content-Type': 'application/json' });
    }

    getAllLocations() {
        return axios.get( `${ this.baseUrl }location/` ).then( r => r.data );
    }

    getAllReports() {
        return axios.get( `${ this.baseUrl }report/` ).then( r => r.data );
    }

    addCalorieEntry( date, calories, id ) {
        return axios.post( `${ this.baseUrl }calorieEntries`, { id: id, userId: this.userId, date: date, weight: calories });
    }
    deleteCalorieEntry( id ) {
        return axios.delete(`${this.baseUrl}calorieEntries/${id}`)
    }
}

const httpService = new HttpService();

export default httpService;
