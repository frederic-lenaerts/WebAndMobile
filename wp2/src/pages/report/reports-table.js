import React from 'react'
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table'

const Row = ( props ) => (
    <TableRow >
        <TableRowColumn >
            { props.entry.id }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.date }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.location.name }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.handled ? 'yes' : 'no' }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.technician.name }
        </TableRowColumn>
    </TableRow>
)

const Rows = ( props ) => props.entries.map( e => (
    <Row entry={ e } key={ e.id } />
))

const ReportsTable = ( props ) => (
    <Table 
        fixedHeader={ true }
        selectable={ false }
        multiSelectable={ false }>
        <TableHeader
            displaySelectAll={ false }
            adjustForCheckbox={ true }
            enableSelectAll={ false}
        >
            <TableRow style={{ textAlign: 'left' }}>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Date</TableHeaderColumn>
                <TableHeaderColumn>Location</TableHeaderColumn>
                <TableHeaderColumn>Handled</TableHeaderColumn>
                <TableHeaderColumn>Technician</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody displayRowCheckbox={ false }>
            <Rows entries={ props.entries } />
        </TableBody>
    </Table>
)

export default ReportsTable
