import React, { Component } from 'react';
import AppBar from 'material-ui/AppBar';
import Drawer from 'material-ui/Drawer';
import MenuItem from 'material-ui/MenuItem';
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';


class View extends Component {
    
    constructor( props ) {
        super( props );
        this.state = { open: false };
    }

    handleToggle = () => this.setState({ open: !this.state.open });

    handleClose = () => this.setState({ open: false });

    render() {
        return (
            <div>
                <AppBar 
                    title={ this.props.title } 
                    onLeftIconButtonTouchTap={ this.handleToggle } 
                />
                <Drawer
                    docked={ false }
                    width={ 200 }
                    open={ this.state.open }
                    onRequestChange={( open ) => this.setState({ open })}
                >
                    <AppBar 
                        title={ this.props.title } 
                        onLeftIconButtonTouchTap={ this.handleToggle } 
                    />
                    <MenuItem 
                        onClick={ this.handleClose } 
                        containerElement={ <Link to="/"></Link> } 
                    >
                        Dashboard
                    </MenuItem>
                    <MenuItem 
                        onClick={ this.handleClose } 
                        containerElement={ <Link to="/status"></Link> } 
                    >
                        Status
                    </MenuItem>
                    <MenuItem 
                        onClick={ this.handleClose } 
                        containerElement={ <Link to="/reports"></Link> } 
                    >
                        Reports
                    </MenuItem>
                    <MenuItem 
                        onClick={ this.handleClose }
                        containerElement={ <Link to="/locations"></Link>} 
                    >
                        Locations
                    </MenuItem>
                    <MenuItem 
                        onClick={ this.handleClose }
                        containerElement={ <Link to="/actions"></Link>} 
                    >
                        Actions
                    </MenuItem>
                    <MenuItem 
                        onClick={ this.handleClose } 
                        containerElement={ <Link to="/technicians"></Link> } 
                    >
                        Technicians
                    </MenuItem>
                </Drawer>
            </div>
        );
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        title: state.title,
    }
}

export default connect( mapStateToProps )( View );
