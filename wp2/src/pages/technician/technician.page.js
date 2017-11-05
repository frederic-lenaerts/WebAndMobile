import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import TechniciansTable from './technicians-table'
import FloatingActionButton from 'material-ui/FloatingActionButton';
import DropDownMenu from 'material-ui/DropDownMenu'
import MenuItem from 'material-ui/MenuItem'
import ContentAdd from 'material-ui/svg-icons/content/add';
import { Link } from 'react-router-dom';

class TechnicianPage extends Component {
    constructor() {
        super()
        this.state = {
            locationMenuItem: -1,
            filteredTechnicianEntries: []
        }
    }

    componentWillMount() {
        if ( !this.props.technicianEntries.length ) {
            HttpService.getAllTechnicians()
                       .then( fetchedEntries => this.props.setTechnicianEntries( fetchedEntries ))
        }
        if ( !this.props.locationEntries.length ) {
            HttpService.getAllLocations()
                       .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
        }
    }

    handleLocationChange = (event, index, menuItem) => {
        var filteredEntries
        if ( !menuItem  ) {
            filteredEntries = this.props.technicianEntries
        } else {
            filteredEntries = this.props.technicianEntries.filter( 
                technician => technician.location.id === menuItem 
            )            
        }
        this.setState({ locationMenuItem: menuItem,
                        filteredTechnicianEntries: filteredEntries })
    }

    render(){
        return (
            <div >
                <div style={{ marginLeft: 24 }}>
                    <div style={{ verticalAlign: 'middle', height: 56, display: 'inline-block' }}>
                        Filter by location
                    </div>
                    <DropDownMenu 
                        value={ this.state.locationMenuItem } 
                        onChange={ this.handleLocationChange } 
                    >
                        <MenuItem value={ -1 } primaryText='Select location' disabled= { true } />
                        <MenuItem value={ 0 } primaryText='All' />
                        { 
                            this.props.locationEntries.map( l => (
                                <MenuItem key={ l.id } value={ l.id } primaryText={ l.name } />
                            ))
                        }
                    </DropDownMenu>
                </div>
                <TechniciansTable entries={ this.state.filteredTechnicianEntries } />
                <Link to="/technicians/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
            </div>
        )
    }

    componentDidMount() {
        this.props.setTitle( 'Technicians' )
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        technicianEntries: state.technicianEntries,
        locationEntries: state.locationEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        ...mapDispatchToPropsTitle( dispatch, ownProps ),
        setTechnicianEntries: ( entries ) => {
            dispatch({ type: 'SET_TECHNICIANENTRIES', payload: entries })
        },
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( TechnicianPage )