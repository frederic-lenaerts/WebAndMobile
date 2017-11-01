import React, { Component } from 'react'
import { Route } from 'react-router-dom'
import DashboardPage from '../pages/dashboard/dashboard.page'
import StatusPage from '../pages/status/status.page'
import StatusAddPage from '../pages/status/status-add.page'
import ReportPage from '../pages/report/report.page'
import LocationPage from '../pages/location/location.page'

class Routes extends Component {
    render() {
        return (
            <div>
                <Route exact={ true } path='/' component={ DashboardPage } />
                <Route exact={ true } path='/status' component={ StatusPage } />
                <Route path='/status/add' component={StatusAddPage} />
                <Route path='/reports' component={ ReportPage } />
                <Route path='/locations' component={ LocationPage } />
            </div>
        )
    }
}

export default Routes;
