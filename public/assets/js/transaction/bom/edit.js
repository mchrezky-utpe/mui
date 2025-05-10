$(document).ready(function() {
    // Data structure to hold our tree with enhanced IDs
    const treeData = [];
    let nextId = 1; // Auto-increment ID for easier tracking
    
    // Function to generate unique ID
    function generateId() {
        return nextId++;
    }
    
    // Function to update level options based on existing tree
    function updateLevelOptions() {
        let maxLevel = 1;
        
        function checkLevel(items, currentLevel) {
            items.forEach(item => {
                if (currentLevel > maxLevel) maxLevel = currentLevel;
                if (item.children && item.children.length > 0) {
                    checkLevel(item.children, currentLevel + 1);
                }
            });
        }
        
        checkLevel(treeData, 1);
        
        // Update level select options
        $('#level').empty();
        for (let i = 1; i <= maxLevel + 1; i++) {
            $('#level').append($('<option>', {
                value: i,
                text: `Level ${i}`
            }));
        }
    }
    
    // Function to update parent options based on selected level
    function updateParentOptions() {
        const selectedLevel = parseInt($('#level').val());
        
        // If level is 1, no parent needed
        if (selectedLevel === 1) {
            $('#parentGroup').hide();
            return;
        }
        
        $('#parentGroup').show();
        $('#parent').empty();
        
        // Find all items at the previous level
        const parentLevel = selectedLevel - 1;
        const parents = [];
        
        function findParents(items, currentLevel) {
            items.forEach(item => {
                if (currentLevel === parentLevel) parents.push(item);
                if (item.children && item.children.length > 0) {
                    findParents(item.children, currentLevel + 1);
                }
            });
        }
        
        findParents(treeData, 1);
        
        if (parents.length === 0) {
            // No parents available at the required level
            $('#parent').append($('<option>', {
                text: 'No available parents',
                disabled: true
            }));
            $('#addBtn').prop('disabled', true);
        } else {
            parents.forEach(parent => {
                $('#parent').append($('<option>', {
                    value: parent.id,
                    text: `${parent.name} (${parent.value}) - ID: ${parent.id}`
                }));
            });
            $('#addBtn').prop('disabled', false);
        }
    }
    
    // Function to add data to the tree
    function addDataToTree() {
        const name = $('#dataName').val().trim();
        const value = $('#dataValue').val().trim();
        const level = parseInt($('#level').val());
        
        if (!name || !value) {
            alert('Please enter both name and desc');
            return;
        }
        
        const newItem = {
            id: generateId(), // Use our auto-increment ID
            name,
            value,
            level,
            children: []
        };
        
        if (level === 1) {
            // Add to root level
            treeData.push(newItem);
        } else {
            // Find the parent and add to its children
            const parentId = parseInt($('#parent').val());
            
            function findParent(items) {
                for (const item of items) {
                    if (item.id === parentId) {
                        item.children.push(newItem);
                        return true;
                    }
                    if (item.children && item.children.length > 0) {
                        if (findParent(item.children)) return true;
                    }
                }
                return false;
            }
            
            findParent(treeData);
        }
        
        // Clear inputs
        $('#dataName, #dataValue').val('');
        
        // Update UI
        updateLevelOptions();
        updateParentOptions();
        renderTree();
    }
    
    // Function to delete an item from the tree
    function deleteItem(id) {
        function removeFromTree(items) {
            for (let i = 0; i < items.length; i++) {
                if (items[i].id === id) {
                    items.splice(i, 1);
                    return true;
                }
                if (items[i].children && items[i].children.length > 0) {
                    if (removeFromTree(items[i].children)) {
                        return true;
                    }
                }
            }
            return false;
        }
        
        removeFromTree(treeData);
        renderTree();
        updateLevelOptions();
        updateParentOptions();
    }
    
    // Function to render the tree view with delete buttons
    function renderTree() {
        if (treeData.length === 0) {
            $('#treeView').html('<p>No tree components added yet.</p>');
            return;
        }
        
        let html = '';
        
        function renderItems(items) {
            items.forEach(item => {
                html += `<div class="tree-node" data-id="${item.id}">
                    <span class="node-label">${item.name}</span>: 
                    <span class="node-value">${item.value}</span> 
                    <span>(Level ${item.level}, ID: ${item.id})</span>
                    <span class="node-actions">
                        <button class="btn btn-danger" data-id="${item.id}">Delete</button>
                    </span>`;
                
                if (item.children && item.children.length > 0) {
                    html += '<div>';
                    renderItems(item.children);
                    html += '</div>';
                }
                
                html += '</div>';
            });
        }
        
        renderItems(treeData);
        $('#treeView').html(html);
        
        // Attach delete event handlers
        $('.delete').on('click', function() {
            const id = parseInt($(this).data('id'));
            if (confirm('Are you sure you want to delete this item?')) {
                deleteItem(id);
            }
        });
    }
    
    // Function to save/export tree data
    function saveTreeData() {
        const jsonData = JSON.stringify(treeData, null, 2);
        $('#jsonOutput').html('<pre>' + jsonData + '</pre>');
        
        console.log('Tree data to save:', treeData);
        alert('Tree data has been prepared for saving (check console or the JSON output below)');
    }
    
    // Event listeners
    $('#level').on('change', updateParentOptions);
    $('#addBtn').on('click', addDataToTree);
    $('#saveBtn').on('click', saveTreeData);
    
    // Initialize
    updateLevelOptions();
    updateParentOptions();
});