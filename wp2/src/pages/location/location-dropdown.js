import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import DropDownMenu from 'material-ui/DropDownMenu';
import MenuItem from 'material-ui/MenuItem';

class LocationDropDown extends Component {

  constructor( props ) {
    super( props );
    this.state = { 
        value: -1
    };
  }

  componentWillMount() {
    if ( this.props.locationEntries.length === 0 ) {
        HttpService.getAllLocations()
                   .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
    }  
  }

  handleChange = (event, index, value) => this.setState({ value });

  render() {
        return (
            <DropDownMenu value={ this.state.value } onChange={ this.handleChange }>
                <MenuItem value={ -1 } primaryText='Select location' disabled= { true } />
                { 
                    this.props.locationEntries.map( l => (
                        <MenuItem key={ l.id } value={ l.id } primaryText={ l.name } />
                    ))
                }
            </DropDownMenu>
        );
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        locationEntries: state.locationEntries
    }
}

const mapDispatchToProps = ( dispatch, ownProps ) => {
    return {
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( LocationDropDown )