import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../../common/title-dispatch-to-props';

class DashboardPage extends Component {
    render(){
        return (
            <div>
                <h2>Welcome</h2>
                <p>Have something to say? Then you have come to the right place! Give us feedback on your toilet experience.</p>
            </div>
        )
    }
    componentDidMount() {
        this.props.setTitle( 'Dashboard' );
    }    
}

export default connect( undefined, mapDispatchToProps )( DashboardPage );
