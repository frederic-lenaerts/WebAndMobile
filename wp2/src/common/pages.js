import React, { Component } from 'react'
import { Route } from 'react-router-dom'
import DashboardPage from '../pages/dashboard/dashboard.page'
import StatusPage from '../pages/status/status.page'
import StatusAddPage from '../pages/status/status-add.page'
import ReportPage from '../pages/report/report.page'
import ReportAddPage from '../pages/report/report-add.page'
import LocationPage from '../pages/location/location.page'
import ActionPage from '../pages/action/action.page'
import ActionAddPage from '../pages/action/action-add.page'
import TechnicianPage from '../pages/technician/technician.page'
import TechnicianAddPage from '../pages/technician/technician-add.page'

class Pages extends Component {
    render() {
        return (
            <div>
                <Route exact={ true } path='/' component={ DashboardPage } />
                <Route exact={ true } path='/status' component={ StatusPage } />
                <Route path='/status/add' component={StatusAddPage} />
                <Route exact={ true } path='/reports' component={ ReportPage } />
                <Route path='/reports/add' component={ ReportAddPage } />
                <Route path='/locations' component={ LocationPage } />
                <Route exact={ true } path='/actions' component={ ActionPage } />
                <Route path='/actions/add' component={ ActionAddPage } />
                <Route exact={ true } path='/technicians' component={ TechnicianPage } />
                <Route path='/technicians/add' component={ TechnicianAddPage } />
            </div>
        )
    }
}

export default Pages;
