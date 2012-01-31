// Copyright 2009 Google Inc.
// All Rights Reserved.

/**
 * This file exposes the external Google Visualization API.
 *
 * The file can be used to enable auto complete of objects and methods provided by the
 * Google Visualization API, and for easier exploration of the API.
 *
 * To enable auto complete in a development environment - copy the file into the project
 * you are working on where the development tool you are using can index the file.
 *
 * Disclaimer: there may be missing classes and methods and the file may
 * be updated and/or changed. For the most up to date API reference please visit:
 * {@link http://code.google.com/intl/iw/apis/visualization/documentation/reference.html}
 */

var google = {};
google.visualization = {};

google.visualization.DataTable = function(opt_data, opt_version) {};
google.visualization.DataTable.prototype.getNumberOfRows = function() {};
google.visualization.DataTable.prototype.getNumberOfColumns = function() {};
google.visualization.DataTable.prototype.clone = function() {};
google.visualization.DataTable.prototype.getColumnId = function(columnIndex) {};
google.visualization.DataTable.prototype.getColumnIndex = function(columnId) {};
google.visualization.DataTable.prototype.getColumnLabel = function(columnIndex) {};
google.visualization.DataTable.prototype.getColumnPattern = function(columnIndex) {};
google.visualization.DataTable.prototype.getColumnRole = function(columnIndex) {};
google.visualization.DataTable.prototype.getColumnType = function(columnIndex) {};
google.visualization.DataTable.prototype.getValue = function(rowIndex, columnIndex) {};
google.visualization.DataTable.prototype.getFormattedValue = function(rowIndex, columnIndex) {};
google.visualization.DataTable.prototype.getProperty = function(rowIndex, columnIndex, property) {};
google.visualization.DataTable.prototype.getProperties = function(rowIndex, columnIndex) {};
google.visualization.DataTable.prototype.getTableProperties = function() {};
google.visualization.DataTable.prototype.getTableProperty = function(property) {};
google.visualization.DataTable.prototype.setTableProperties = function(properties) {};
google.visualization.DataTable.prototype.setTableProperty = function(property, value) {};
google.visualization.DataTable.prototype.setValue = function(rowIndex, columnIndex, value) {};
google.visualization.DataTable.prototype.setFormattedValue = function(rowIndex, columnIndex, formattedValue) {};
google.visualization.DataTable.prototype.setProperties = function(rowIndex, columnIndex, properties) {};
google.visualization.DataTable.prototype.setProperty = function(rowIndex, columnIndex, property, value) {};
google.visualization.DataTable.prototype.setCell = function(rowIndex, columnIndex, opt_value, opt_formattedValue, opt_properties) {};
google.visualization.DataTable.prototype.setRowProperties = function(rowIndex, properties) {};
google.visualization.DataTable.prototype.setRowProperty = function(rowIndex, property, value) {};
google.visualization.DataTable.prototype.getRowProperty = function(rowIndex, property) {};
google.visualization.DataTable.prototype.getRowProperties = function(rowIndex) {};
google.visualization.DataTable.prototype.setColumnLabel = function(columnIndex, newLabel) {};
google.visualization.DataTable.prototype.setColumnProperties = function(columnIndex, properties) {};
google.visualization.DataTable.prototype.setColumnProperty = function(columnIndex, property, value) {};
google.visualization.DataTable.prototype.getColumnProperty = function(columnIndex, property) {};
google.visualization.DataTable.prototype.getColumnProperties = function(columnIndex) {};
google.visualization.DataTable.prototype.insertColumn = function(atColIndex, type, opt_label, opt_id) {};
google.visualization.DataTable.prototype.addColumn = function(type, opt_label, opt_id) {};
google.visualization.DataTable.prototype.insertRows = function(atRowIndex, numOrArray) {};
google.visualization.DataTable.prototype.addRows = function(numOrArray) {};
google.visualization.DataTable.prototype.addRow = function(opt_cellArray) {};
google.visualization.DataTable.prototype.getColumnRange = function(columnIndex) {};
google.visualization.DataTable.prototype.getSortedRows = function(sortColumns) {};
google.visualization.DataTable.prototype.sort = function(sortColumns) {};
google.visualization.DataTable.prototype.getDistinctValues = function(column) {};
google.visualization.DataTable.prototype.getFilteredRows = function(columnFilters) {};
google.visualization.DataTable.prototype.removeRows = function(fromRowIndex, numRows) {};
google.visualization.DataTable.prototype.removeRow = function(rowIndex) {};
google.visualization.DataTable.prototype.removeColumns = function(fromColIndex, numCols) {};
google.visualization.DataTable.prototype.removeColumn = function(colIndex) {};
google.visualization.DataTable.prototype.toJSON = function() {};

google.visualization.QueryResponse = function(responseObj) {};
google.visualization.QueryResponse.getVersionFromResponse = function(responseObj) {};
google.visualization.QueryResponse.prototype.getVersion = function() {};
google.visualization.QueryResponse.prototype.getExecutionStatus = function() {};
google.visualization.QueryResponse.prototype.isError = function() {};
google.visualization.QueryResponse.prototype.hasWarning = function() {};
google.visualization.QueryResponse.prototype.containsReason = function(reason) {};
google.visualization.QueryResponse.prototype.getDataSignature = function() {};
google.visualization.QueryResponse.prototype.getDataTable = function() {};
google.visualization.QueryResponse.prototype.getReasons = function() {};
google.visualization.QueryResponse.prototype.getMessage = function() {};
google.visualization.QueryResponse.prototype.getDetailedMessage = function() {};

google.visualization.Query = function(dataSourceUrl) {};
google.visualization.Query.refreshAllQueries = function() {};
google.visualization.Query.setResponse = function(response) {};
google.visualization.Query.prototype.setRefreshInterval = function(intervalSeconds) {};
google.visualization.Query.prototype.send = function(responseHandler) {};
google.visualization.Query.prototype.makeRequest = function(responseHandler, opt_params) {};
google.visualization.Query.prototype.abort = function() {};
google.visualization.Query.prototype.setTimeout = function(timeoutSeconds) {};
google.visualization.Query.prototype.setRefreshable = function(refreshable) {};
google.visualization.Query.prototype.setQuery = function(queryString) {};

google.visualization.errors = {};
google.visualization.errors.addError = function(container, message, opt_detailedMessage, opt_options) {};
google.visualization.errors.removeAll = function(container) {};
google.visualization.errors.addErrorFromQueryResponse = function(container, response) {};
google.visualization.errors.removeError = function(id) {};
google.visualization.errors.getContainer = function(errorId) {};

google.visualization.events = {};
google.visualization.events.addListener = function(eventSource, eventName, eventHandler) {};
google.visualization.events.trigger = function(eventSource, eventName, eventDetails) {};
google.visualization.events.removeListener = function(listener) {};
google.visualization.events.removeAllListeners = function(eventSource) {};

google.visualization.DataView = function(dataTable) {};
google.visualization.DataView.fromJSON = function(dataTable, view) {};
google.visualization.DataView.prototype.setColumns = function(colIndices) {};
google.visualization.DataView.prototype.setRows = function(arg0, opt_arg1) {};
google.visualization.DataView.prototype.getViewColumns = function() {};
google.visualization.DataView.prototype.getViewRows = function() {};
google.visualization.DataView.prototype.hideColumns = function(colIndices) {};
google.visualization.DataView.prototype.hideRows = function(arg0, opt_arg1) {};
google.visualization.DataView.prototype.getViewColumnIndex = function(tableColumnIndex) {};
google.visualization.DataView.prototype.getViewRowIndex = function(tableRowIndex) {};
google.visualization.DataView.prototype.getTableColumnIndex = function(viewColumnIndex) {};
google.visualization.DataView.prototype.getUnderlyingTableColumnIndex = function(viewColumnIndex) {};
google.visualization.DataView.prototype.getTableRowIndex = function(viewRowIndex) {};
google.visualization.DataView.prototype.getUnderlyingTableRowIndex = function(viewRowIndex) {};
google.visualization.DataView.prototype.getNumberOfRows = function() {};
google.visualization.DataView.prototype.getNumberOfColumns = function() {};
google.visualization.DataView.prototype.getColumnId = function(columnIndex) {};
google.visualization.DataView.prototype.getColumnIndex = function(columnId) {};
google.visualization.DataView.prototype.getColumnLabel = function(columnIndex) {};
google.visualization.DataView.prototype.getColumnPattern = function(columnIndex) {};
google.visualization.DataView.prototype.getColumnRole = function(columnIndex) {};
google.visualization.DataView.prototype.getColumnType = function(columnIndex) {};
google.visualization.DataView.prototype.getValue = function(rowIndex, columnIndex) {};
google.visualization.DataView.prototype.getFormattedValue = function(rowIndex, columnIndex) {};
google.visualization.DataView.prototype.getProperty = function(rowIndex, columnIndex, property) {};
google.visualization.DataView.prototype.getColumnProperty = function(columnIndex, property) {};
google.visualization.DataView.prototype.getColumnProperties = function(columnIndex) {};
google.visualization.DataView.prototype.getTableProperty = function(property) {};
google.visualization.DataView.prototype.getTableProperties = function() {};
google.visualization.DataView.prototype.getRowProperty = function(rowIndex, property) {};
google.visualization.DataView.prototype.getRowProperties = function(rowIndex) {};
google.visualization.DataView.prototype.getColumnRange = function(columnIndex) {};
google.visualization.DataView.prototype.getDistinctValues = function(columnIndex) {};
google.visualization.DataView.prototype.getSortedRows = function(sortColumns) {};
google.visualization.DataView.prototype.getFilteredRows = function(columnFilters) {};
google.visualization.DataView.prototype.toDataTable = function() {};
google.visualization.DataView.prototype.toJSON = function() {};

google.visualization.ArrowFormat = function(opt_options) {};
google.visualization.ArrowFormat.prototype.format = function(dataTable, columnIndex) {};

google.visualization.BarFormat = function(opt_options) {};
google.visualization.BarFormat.prototype.format = function(dataTable, columnIndex) {};

google.visualization.ColorFormat = function() {};
google.visualization.ColorFormat.prototype.addRange = function(from, to, color, bgcolor) {};
google.visualization.ColorFormat.prototype.addGradientRange = function(from, to, color, fromBgColor, toBgColor) {};
google.visualization.ColorFormat.prototype.format = function(dataTable, columnIndex) {};

google.visualization.DateFormat = function(opt_options) {};
google.visualization.DateFormat.prototype.format = function(dataTable, columnIndex) {};
google.visualization.DateFormat.prototype.formatValue = function(value) {};

google.visualization.NumberFormat = function(opt_options) {};
google.visualization.NumberFormat.prototype.format = function(dataTable, columnIndex) {};
google.visualization.NumberFormat.prototype.formatValue = function(value) {};
google.visualization.NumberFormat.DECIMAL_SEP;
google.visualization.NumberFormat.GROUP_SEP;
google.visualization.NumberFormat.DECIMAL_PATTERN;

google.visualization.PatternFormat = function(pattern) {};
google.visualization.PatternFormat.prototype.format = function(dataTable, srcColumnIndices, opt_dstColumnIndex) {};

google.visualization.GadgetHelper = function() {};
google.visualization.GadgetHelper.prototype.createQueryFromPrefs = function(prefs) {};
google.visualization.GadgetHelper.prototype.validateResponse = function(response) {};

google.visualization.AnnotatedTimeLine = function(container) {};
google.visualization.AnnotatedTimeLine.prototype.draw = function(data, opt_options) {};
google.visualization.AnnotatedTimeLine.prototype.getSelection = function() {};
google.visualization.AnnotatedTimeLine.prototype.getVisibleChartRange = function() {};
google.visualization.AnnotatedTimeLine.prototype.setVisibleChartRange = function(firstDate, lastDate, opt_animate) {};
google.visualization.AnnotatedTimeLine.prototype.showDataColumns = function(columnIndexes) {};
google.visualization.AnnotatedTimeLine.prototype.hideDataColumns = function(columnIndexes) {};

google.visualization.AreaChart = function(container) {};
google.visualization.AreaChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.AreaChart.prototype.clearChart = function() {};
google.visualization.AreaChart.prototype.getSelection = function() {};
google.visualization.AreaChart.prototype.setSelection = function(selection) {};

google.visualization.BarChart = function(container) {};
google.visualization.BarChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.BarChart.prototype.clearChart = function() {};
google.visualization.BarChart.prototype.getSelection = function() {};
google.visualization.BarChart.prototype.setSelection = function(selection) {};

google.visualization.CandlestickChart = function(container) {};
google.visualization.CandlestickChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.CandlestickChart.prototype.clearChart = function() {};
google.visualization.CandlestickChart.prototype.getSelection = function() {};
google.visualization.CandlestickChart.prototype.setSelection = function(selection) {};

google.visualization.ColumnChart = function(container) {};
google.visualization.ColumnChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.ColumnChart.prototype.clearChart = function() {};
google.visualization.ColumnChart.prototype.getSelection = function() {};
google.visualization.ColumnChart.prototype.setSelection = function(selection) {};

google.visualization.ComboChart = function(container) {};
google.visualization.ComboChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.ComboChart.prototype.clearChart = function() {};
google.visualization.ComboChart.prototype.getSelection = function() {};
google.visualization.ComboChart.prototype.setSelection = function(selection) {};

google.visualization.Gauge = function(container) {};
google.visualization.Gauge.prototype.draw = function(dataTable, opt_options) {};
google.visualization.Gauge.prototype.clearChart = function() {};

google.visualization.GeoChart = function(container) {};
google.visualization.GeoChart.mapExists = function(userOptions) {};
google.visualization.GeoChart.prototype.clearChart = function() {};
google.visualization.GeoChart.prototype.draw = function(dataTable, userOptions, opt_state) {};
google.visualization.GeoChart.prototype.getSelection = function() {};
google.visualization.GeoChart.prototype.setSelection = function(selection) {};

google.visualization.GeoMap = function(container) {};
google.visualization.GeoMap.clickOnRegion = function(id, zoomLevel, segmentBy, instanceIndex) {};
google.visualization.GeoMap.prototype.draw = function(dataTable, opt_options) {};
google.visualization.GeoMap.prototype.getSelection = function() {};
google.visualization.GeoMap.prototype.setSelection = function(selection) {};

google.visualization.Map = function(container) {};
google.visualization.Map.prototype.draw = function(dataTable, opt_options) {};
google.visualization.Map.prototype.getSelection = function() {};
google.visualization.Map.prototype.setSelection = function(selection) {};

google.visualization.ImageAreaChart = function(container) {};
google.visualization.ImageAreaChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImageBarChart = function(container) {};
google.visualization.ImageBarChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImageCandlestickChart = function(container) {};
google.visualization.ImageCandlestickChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImageChart = function(container) {};
google.visualization.ImageChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImageLineChart = function(container) {};
google.visualization.ImageLineChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImagePieChart = function(container) {};
google.visualization.ImagePieChart.prototype.draw = function(data, opt_options) {};

google.visualization.ImageSparkLine = function(container, opt_domHelper) {};
google.visualization.ImageSparkLine.prototype.draw = function(dataTable, opt_options) {};
google.visualization.ImageSparkLine.prototype.getSelection = function() {};
google.visualization.ImageSparkLine.prototype.setSelection = function(selection) {};

google.visualization.IntensityMap = function(container) {};
google.visualization.IntensityMap.prototype.draw = function(dataTable, opt_options) {};
google.visualization.IntensityMap.prototype.getSelection = function() {};
google.visualization.IntensityMap.prototype.setSelection = function(selection) {};

google.visualization.LineChart = function(container) {};
google.visualization.LineChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.LineChart.prototype.clearChart = function() {};
google.visualization.LineChart.prototype.getSelection = function() {};
google.visualization.LineChart.prototype.setSelection = function(selection) {};

google.visualization.MotionChart = function(container) {};
google.visualization.MotionChart.prototype.draw = function(dataTable, opt_options) {};
google.visualization.MotionChart.prototype.getState = function() {};

google.visualization.OrgChart = function(container) {};
google.visualization.OrgChart.prototype.draw = function(dataTable, opt_options) {};
google.visualization.OrgChart.prototype.getSelection = function() {};
google.visualization.OrgChart.prototype.setSelection = function(selection) {};
google.visualization.OrgChart.prototype.getCollapsedNodes = function() {};
google.visualization.OrgChart.prototype.getChildrenIndexes = function(rowInd) {};
google.visualization.OrgChart.prototype.collapse = function(rowInd, collapse) {};

google.visualization.PieChart = function(container) {};
google.visualization.PieChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.PieChart.prototype.clearChart = function() {};
google.visualization.PieChart.prototype.getSelection = function() {};
google.visualization.PieChart.prototype.setSelection = function(selection) {};

google.visualization.ScatterChart = function(container) {};
google.visualization.ScatterChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.ScatterChart.prototype.clearChart = function() {};
google.visualization.ScatterChart.prototype.getSelection = function() {};
google.visualization.ScatterChart.prototype.setSelection = function(selection) {};

google.visualization.SparklineChart = function(container) {};
google.visualization.SparklineChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.SparklineChart.prototype.clearChart = function() {};
google.visualization.SparklineChart.prototype.getSelection = function() {};
google.visualization.SparklineChart.prototype.setSelection = function(selection) {};

google.visualization.SteppedAreaChart = function(container) {};
google.visualization.SteppedAreaChart.prototype.draw = function(data, opt_options, opt_state) {};
google.visualization.SteppedAreaChart.prototype.clearChart = function() {};
google.visualization.SteppedAreaChart.prototype.getSelection = function() {};
google.visualization.SteppedAreaChart.prototype.setSelection = function(selection) {};

google.visualization.Table = function(container) {};
google.visualization.Table.prototype.draw = function(dataTable, opt_options) {};
google.visualization.Table.prototype.clearChart = function() {};
google.visualization.Table.prototype.getSortInfo = function() {};
google.visualization.Table.prototype.getSelection = function() {};
google.visualization.Table.prototype.setSelection = function(selection) {};

google.visualization.TreeMap = function(container) {};
google.visualization.TreeMap.prototype.draw = function(dataTable, opt_options) {};
google.visualization.TreeMap.prototype.clearChart = function() {};
google.visualization.TreeMap.prototype.getSelection = function() {};
google.visualization.TreeMap.prototype.setSelection = function(selection) {};

google.visualization.drawToolbar = function(container, components) {};
