const initialState = {
    title: 'Dashboard',
    statusEntries: [],
    locationEntries: [],
    reportEntries: [],
    actionEntries: [],
    technicianEntries: []
}

const viewreducer = ( state = initialState, action ) => {
    switch ( action.type ) {
        case 'SET_TITLE':
            return { ...state, ...{ title: action.payload } }
        case 'SET_STATUSENTRIES':
            return { ...state, ...{ statusEntries: action.payload }}
        case 'ADD_STATUSENTRY':
            return { ...state, ...{ statusEntries: [...state.statusEntries, action.payload]}}
        case 'SET_LOCATIONENTRIES':
            return { ...state, ...{ locationEntries: action.payload }}
        case 'SET_REPORTENTRIES':
            return { ...state, ...{ reportEntries: action.payload }}
        case 'ADD_REPORTENTRY':
            return { ...state, ...{ reportEntries: [...state.reportEntries, action.payload]}}
        case 'SET_ACTIONENTRIES':
            return { ...state, ...{ actionEntries: action.payload }}
        case 'ADD_ACTIONENTRY':
            return { ...state, ...{ actionEntries: [...state.actionEntries, action.payload]}}
        case 'SET_TECHNICIANENTRIES':
            return { ...state, ...{ technicianEntries: action.payload }}
        case 'ADD_TECHNICIANENTRY':
            return { ...state, ...{ technicianEntries: [...state.technicianEntries, action.payload]}}
        default:
            return state
    }
}

export default viewreducer