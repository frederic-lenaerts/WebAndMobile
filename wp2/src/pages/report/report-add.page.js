import React, { Component } from 'react'
import { connect } from 'react-redux'
import mapDispatchToPropsTitle from '../../common/title-dispatch-to-props'
import TextField from 'material-ui/TextField';
import DatePicker from 'material-ui/DatePicker'
import FlatButton from 'material-ui/FlatButton'
import DropDownMenu from 'material-ui/DropDownMenu'
import MenuItem from 'material-ui/MenuItem'
import Dialog from 'material-ui/Dialog'
import HttpService from '../../util/http-service'
import { Link } from 'react-router-dom'

class ReportAddPage extends Component {
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
    handleHandledChange = (event, index, menuItem) => this.setState({ handledMenuItem: menuItem })
    handleClose = () => { this.setState({ showInvalidFormDialog: false, showSuccessDialog: false }) }
    handleReload = () => { window.location.reload() }

    render() {
        const successActions = [
            <FlatButton
                label='Add another'
                primary={ true }
                onClick={ this.handleReload }
            />,
            <Link to='/reports'>
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
                    <TextField hintText='Describe the issue' name='text' style={{ marginLeft: 24 }}/>
                    <br />
                    <DatePicker hintText='Select date' name='date' style={{ marginLeft: 24 }}/>
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
                    <div style={{ marginLeft: 24 }}>
                        <div style={{ verticalAlign: 'middle', height: 56, display: 'inline-block' }}>
                            Has it been handled?
                        </div>
                        <DropDownMenu 
                            value={ this.state.handledMenuItem } 
                            onChange={ this.handleHandledChange } 
                            ref={(element) => { this.handled = element }}
                        >
                            <MenuItem value={ -1 } primaryText='Select value' disabled= { true } />
                            <MenuItem key={ 0 } value={ false } primaryText={ 'No' } />
                            <MenuItem key={ 1 } value={ true } primaryText={ 'Yes' } />
                        </DropDownMenu>
                    </div>
                    <br />
                    <FlatButton label='SEND' type='submit' primary={true} style={{ marginLeft: 24 }} />
                </form>
                <Dialog
                    title='Report added'
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

        const date = event.target['date'].value
        const text = event.target['text'].value   
        const locationMenuItem = this.location.props.value
        const location = this.props.locationEntries[locationMenuItem - 1]
        const handled = this.handled.props.value
        const entry = { date, text, handled, location }
       
        if ( this.isValid( entry )) {
            HttpService.addReportEntry( entry ).then( resp => {
                if ( resp.status === 201 ) {
                    this.props.addReport( resp.data )
                    this.setState({ showSuccessDialog: true })
                } else {
                    this.setState({ showFailedMessage: true })
                }      
            })
        } else {
            this.setState({ showInvalidFormDialog: true })
        }   
    }

    isValid = ( entry ) => {
        return entry.date && entry.location && typeof entry.handled === 'boolean'
    }

    componentDidMount() {
        this.props.setTitle('Add new report')
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
        addReport: (entry) => {
            dispatch({ type: 'ADD_REPORTENTRY', payload: entry })
        },
        setLocationEntries: ( entries ) => {
            dispatch({ type: 'SET_LOCATIONENTRIES', payload: entries })
        }
    }
}

export default connect( mapStateToProps, mapDispatchToProps )( ReportAddPage )
