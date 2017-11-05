import React, { Component } from 'react'
import { connect } from 'react-redux'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import TextField from 'material-ui/TextField'
import FlatButton from 'material-ui/FlatButton'
import DropDownMenu from 'material-ui/DropDownMenu'
import MenuItem from 'material-ui/MenuItem'
import Dialog from 'material-ui/Dialog'
import HttpService from '../../util/http-service'
import { Link } from 'react-router-dom'

class TechnicianAddPage extends Component {
    constructor() {
        super()
        this.state = { 
            showSuccessDialog: false,
            showInvalidFormDialog: false,
            showFailedMessage: false,
            locationMenuItem: -1,
            handledMenuItem: -1
        }
    }

    componentWillMount() {
        if ( !this.props.locationEntries.length ) {
            HttpService.getAllLocations()
                       .then( fetchedEntries => this.props.setLocationEntries( fetchedEntries ))
        }  
    }

    handleLocationChange = (event, index, menuItem) => this.setState({ locationMenuItem: menuItem })
    handleClose = () => { this.setState({ showInvalidFormDialog: false, showSuccessDialog: false }) }
    handleReload = () => { window.location.reload() }

    render() {
        const successActions = [
            <FlatButton
                label='Add another'
                primary={ true }
                onClick={ this.handleReload }
            />,
            <Link to='/technicians'>
                <FlatButton
                    label='Return to overview'
                    primary={ true }
                />
            </Link>
        ]

        const invalidFormActions = [
            <FlatButton label='oops' primary={ true } onClick={ this.handleClose } />
        ]

        const failedMessage = (
            <div style={{ marginLeft: 24, marginRight: 24 }}>
                <span>Communication with the server failed. Please try again later.</span>
            </div>
        )

        return (
            <div>
                <br />
                { this.state.showFailedMessage ? failedMessage : null }
                <form onSubmit={ this.save }>
                    <TextField hintText='Name' name='name' style={{ marginLeft: 24 }}/>
                    <br />
                    <DropDownMenu 
                        value={ this.state.locationMenuItem } 
                        onChange={ this.handleLocationChange } 
                        ref={(element) => { this.location = element }}
                    >
                        <MenuItem value={ -1 } primaryText='Select location' disabled= { true } />
                        { 
                            this.props.locationEntries.map( l => (
                                <MenuItem key={ l.id } value={ l.id } primaryText={ l.name } />
                            ))
                        }
                    </DropDownMenu>
                    <br />
                    <FlatButton label='SEND' type='submit' primary={true} style={{ marginLeft: 24 }} />
                </form>
                <Dialog
                    title='Technician added'
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
        this.setState({ showFailedMessage: false })

        const name = event.target['name'].value   
        const locationMenuItem = this.location.props.value
        const location = this.props.locationEntries[locationMenuItem - 1]
        const entry = { name, location }
       
        if ( this.isValid( entry )) {
            HttpService.addTechnicianEntry( entry ).then( resp => {
                if ( resp.status === 201 ) {
                    console.log("success")
                    this.props.addTechnician( resp.data )
                    this.setState({ showSuccessDialog: true })
                } else {
                    console.log("fail")
                    this.setState({ showFailedMessage: true })
                }      
            })
        } else {
            this.setState({ showInvalidFormDialog: true })
        }   
    }

    isValid = ( entry ) => {
        return entry.name && entry.location
    }

    componentDidMount() {
        this.props.setTitle('Add new technician')
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
        addTechnician: (entry) => {
            dispatch({ type: 'ADD_TECHNICIANENTRY', payload: entry })
        },
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( TechnicianAddPage )
