import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import StatusTable from './status-table'

class StatusPage extends Component {
    componentWillMount() {
        if ( this.props.statusEntries.length === 0 ) {
            HttpService.getAllStatus()
                       .then( fetchedEntries => this.props.setStatusEntries( fetchedEntries ))
        }      
    }
    render(){
        return (
            <div>
                <StatusTable entries={ this.props.statusEntries } />
            </div>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Status' )
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        statusEntries: state.statusEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        ...mapDispatchToPropsTitle( dispatch, ownProps ),
        setStatusEntries: ( entries ) => {
            dispatch({ type: 'SET_STATUSENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( StatusPage )
