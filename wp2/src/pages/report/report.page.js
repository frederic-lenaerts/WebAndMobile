import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import ReportsTable from './reports-table'

class ReportPage extends Component {
    componentWillMount() {
        if ( this.props.reportEntries.length === 0 ) {
            HttpService.getAllReports()
                       .then( fetchedEntries => this.props.setReportEntries( fetchedEntries ))
        }      
    }
    render(){
        return (
            <div>
                <ReportsTable entries={ this.props.reportEntries } />
            </div>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Report' )
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        reportEntries: state.reportEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        ...mapDispatchToPropsTitle( dispatch, ownProps ),
        setReportEntries: ( entries ) => {
            dispatch({ type: 'SET_REPORTENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( ReportPage )
