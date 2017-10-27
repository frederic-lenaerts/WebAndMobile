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
    <TableRow key={ props.entry.id } >
        <TableRowColumn >
            { props.entry.date }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.status }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.location.name }
        </TableRowColumn>
    </TableRow>
)

const Rows = ( props ) => props.entries.map( e => (
    <Row entry={ e } />
))

const StatusTable = ( props ) => (
    <Table 
        fixedHeader={ true }
        selectable={ false }
        multiSelectable={ false }>
        <TableHeader
            displaySelectAll={ false }
            adjustForCheckbox={ true }
            enableSelectAll={ false}
            style={{ textAlign: 'left' }}
        >
            <TableRow style={{ textAlign: 'left' }}>
                <TableHeaderColumn style={{ textAlign: 'left' }}>Date</TableHeaderColumn>
                <TableHeaderColumn>Status</TableHeaderColumn>
                <TableHeaderColumn>location</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody
            displayRowCheckbox={ false }>
            <Rows entries={ props.entries } />
        </TableBody>
    </Table>
)

export default StatusTable
