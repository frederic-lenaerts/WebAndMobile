import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import LocationsTable from './locations-table'

class LocationPage extends Component {
    componentWillMount() {
        if ( this.props.locationEntries.length === 0 ) {
            HttpService.getAllLocations()
                       .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
        }      
    }
    render(){
        return (
            <div>
                <LocationsTable entries={ this.props.locationEntries } />
            </div>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Locations' )
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        locationEntries: state.locationEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        ...mapDispatchToPropsTitle( dispatch, ownProps ),
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( LocationPage )
