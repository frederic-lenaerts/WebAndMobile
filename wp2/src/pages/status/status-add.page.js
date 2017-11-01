import React, { Component } from 'react'
import { connect } from 'react-redux'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import DatePicker from 'material-ui/DatePicker'
import FlatButton from 'material-ui/FlatButton'
import DropDownMenu from 'material-ui/DropDownMenu'
import MenuItem from 'material-ui/MenuItem'
import Dialog from 'material-ui/Dialog'
import HttpService from '../../util/http-service'
import { Link } from 'react-router-dom'

class StatusAddPage extends Component {
    constructor() {
        super()
        this.state = { 
            showSuccessDialog: false,
            showInvalidFormDialog: false,
            locationMenuItem: -1,
            statusMenuItem: -1
        }
    }

    componentWillMount() {
        if ( !this.props.locationEntries.length ) {
            HttpService.getAllLocations()
                       .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
        }  
    }

    handleLocationChange = (event, index, menuItem) => this.setState({ locationMenuItem: menuItem })
    handleStatusChange = (event, index, menuItem) => this.setState({ statusMenuItem: menuItem })
    handleClose = () => { this.setState({ showInvalidFormDialog: false, showSuccessDialog: false }) }
    handleReload = () => { window.location.reload() }

    render() {
        const successActions = [
            <FlatButton
                label='Add another'
                primary={ true }
                onClick={ this.handleReload }
            />,
            <Link to='/status'>
                <FlatButton
                    label='Return to overview'
                    primary={ true }
                />
            </Link>
        ]

        const invalidFormActions= [
            <FlatButton label='oops' primary={ true } onClick={ this.handleClose } />
        ]

        return (
            <div>
                <br />
                <form onSubmit={ this.save }>
                    <DatePicker hintText='Select Date' name='date' style={{ marginLeft: 24 }}/>
                    <br />
                    <DropDownMenu value={ this.state.locationMenuItem } onChange={ this.handleLocationChange } ref={(element) => { this.location = element }}>
                        <MenuItem value={ -1 } primaryText='Select location' disabled= { true } />
                        { 
                            this.props.locationEntries.map( l => (
                                <MenuItem key={ l.id } value={ l.id } primaryText={ l.name } />
                            ))
                        }
                    </DropDownMenu>
                    <br />
                    <DropDownMenu value={ this.state.statusMenuItem } onChange={ this.handleStatusChange } ref={(element) => { this.status = element }}>
                        <MenuItem value={ -1 } primaryText='Select status' disabled= { true } />
                        <MenuItem key={ 0 } value={ 0 } primaryText={ 'Poor' } />
                        <MenuItem key={ 1 } value={ 1 } primaryText={ 'Average' } />
                        <MenuItem key={ 2 } value={ 2 } primaryText={ 'Good' } />
                    </DropDownMenu>
                    <br />
                    <FlatButton label='SEND' type='submit' primary={true} style={{ marginLeft: 24 }} />
                </form>
                <Dialog
                    title='Status added'
                    actions={ successActions }
                    modal={ false }
                    open={ this.state.showSuccessDialog }
                    onRequestClose={ this.handleClose }
                >
                    Thank you for your feedback.
                </Dialog>
                <Dialog
                    title='Invalid form'
                    actions={ invalidFormActions }
                    modal={ false }
                    open={ this.state.showInvalidFormDialog }
                    onRequestClose={ this.handleClose }
                >
                    Please fill out all fields.
                </Dialog>
            </div>
        )
    }

    save = ( event ) => {
        event.preventDefault()
        const date = event.target['date'].value        
        const locationMenuItem = this.location.props.value
        const location = this.props.locationEntries[locationMenuItem - 1]
        const status = this.status.props.value
        const entry = {
            date,
            status,
            location
        }
        if ( this.isValid( entry )) {
            HttpService.addStatusEntry( entry ).then( resp => {
                if ( resp.status === 201 ) {
                    this.props.addStatus( resp.data )
                    this.setState({ showSuccessDialog: true })
                }          
            })
        } else {
            this.setState({ showInvalidFormDialog: true })
        }   
    }

    isValid = ( entry ) => {
        return entry.date && entry.location && entry.status !== -1
    }

    componentDidMount() {
        this.props.setTitle('Add new status')
    }
}

const mapStateToProps = ( state, ownProps ) => {
    return {
        locationEntries: state.locationEntries
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addStatus: (entry) => {
            dispatch({ type: 'ADD_STATUSENTRY', payload: entry })
        },
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( StatusAddPage )
