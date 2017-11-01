import React, { Component } from 'react'
import { connect } from "react-redux"
import HttpService from '../../util/http-service'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import StatusTable from './status-table'
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';
import { Link } from 'react-router-dom';

class StatusPage extends Component {
    componentWillMount() {
        if ( this.props.statusEntries.length === 0) {
            HttpService.getAllStatus()
                       .then( fetchedEntries => this.props.setStatusEntries( fetchedEntries ))
        }
    }
    render(){
        return (
            <div>
                <StatusTable entries={ this.props.statusEntries } />
                <Link to="/status/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
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
