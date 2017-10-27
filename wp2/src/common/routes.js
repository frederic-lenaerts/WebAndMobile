import React, { Component } from 'react'
import { Route } from 'react-router-dom'
import DashboardPage from '../pages/dashboard/dashboard.page'
import StatusPage from '../pages/status/status.page'
import ProblemsPage from '../pages/problems/problems.page'
import LocationsPage from '../pages/locations/locations.page'

class Routes extends Component {
    render() {
        return (
            <div>
                <Route exact={ true } path="/" component={ DashboardPage } />
                <Route path="/status" component={ StatusPage } />
                <Route path="/problems" component={ ProblemsPage } />
                <Route path="/locations" component={ LocationsPage } />
            </div>
        )
    }
}

export default Routes;
