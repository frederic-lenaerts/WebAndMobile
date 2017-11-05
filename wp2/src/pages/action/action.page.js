import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import ActionsTable from './actions-table'
import FloatingActionButton from 'material-ui/FloatingActionButton';
import DropDownMenu from 'material-ui/DropDownMenu'
import MenuItem from 'material-ui/MenuItem'
import ContentAdd from 'material-ui/svg-icons/content/add';
import { Link } from 'react-router-dom';

class ActionPage extends Component {
    constructor() {
        super()
        this.state = {
            locationMenuItem: -1,
            filteredActionEntries: []
        }
    }

    componentWillMount() {
        if ( !this.props.actionEntries.length ) {
            HttpService.getAllActions()
                       .then( fetchedEntries => this.props.setActionEntries( fetchedEntries ))
        }
        if ( !this.props.locationEntries.length ) {
            HttpService.getAllLocations()
                       .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
        }
    }

    handleLocationChange = (event, index, menuItem) => {
        var filteredEntries
        if ( !menuItem  ) {
            filteredEntries = this.props.actionEntries
        } else {
            filteredEntries = this.props.actionEntries.filter( 
                action => action.location.id === menuItem 
            )            
        }
        this.setState({ locationMenuItem: menuItem,
                        filteredActionEntries: filteredEntries })
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
                <ActionsTable entries={ this.state.filteredActionEntries } />
                <Link to="/actions/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
            </div>
        )
    }

    componentDidMount() {
        this.props.setTitle( 'Actions' )
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        actionEntries: state.actionEntries,
        locationEntries: state.locationEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        ...mapDispatchToPropsTitle( dispatch, ownProps ),
        setActionEntries: ( entries ) => {
            dispatch({ type: 'SET_ACTIONENTRIES', payload: entries })
        },
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( ActionPage )
