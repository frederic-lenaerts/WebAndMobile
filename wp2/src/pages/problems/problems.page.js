import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../../common/title-dispatch-to-props';

class ProblemsPage extends Component {
    render(){
        return (
            <h2>Problems</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Problems' );
    }    
}

export default connect( undefined, mapDispatchToProps )( ProblemsPage );
