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

    addReportEntry( report ) {
        return axios.post( `${ this.baseUrl }report/`, report, { 'Content-Type': 'application/json' });
    }

    getAllActions() {
        return axios.get( `${ this.baseUrl }action/` ).then( r => r.data );
    }

    addActionEntry( action ) {
        return axios.post( `${ this.baseUrl }action/`, action, { 'Content-Type': 'application/json' });
    }
}

const httpService = new HttpService();

export default httpService;
