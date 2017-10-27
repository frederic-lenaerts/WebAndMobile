import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../../common/title-dispatch-to-props';

class LocationsPage extends Component {
    render(){
        return (
            <h2>Locations</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Locations' );
    }    
}

export default connect( undefined, mapDispatchToProps )( LocationsPage );
