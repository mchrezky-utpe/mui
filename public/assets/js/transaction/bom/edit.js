$(document).ready(function() {
    // Data structure to hold our tree with enhanced IDs
    const treeData = [];
    var skuData;
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
                    text: `${parent.sku_name} (${parent.qty_capacity}) - ID: ${parent.id}`
                }));
            });
            $('#addBtn').prop('disabled', false);
        }
    }
    
    // Function to add data to the tree
    function addDataToTree() {
        const sku_id = $('#sku_id').val().trim();
        const sku_name = $('#sku_id :selected').text().trim();
        const qty_capacity = $('#qty_capacity').val().trim();
        const qty_each_unit = parseInt($('#qty_each_unit').val());
        const description = $('#description').val().trim();

        const level = parseInt($('#level').val());
        
        if (!sku_id || !qty_capacity) {
            alert('Please correct data');
            return;
        }
        
        const newItem = {
            id: generateId(), // Use our auto-increment ID
            sku_id,
            sku_name,
            qty_capacity,
            qty_each_unit,
            description,
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
        $('#sku_id, #qty_capacity, #qty_each_unit, #description').val('');
        
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
                    <span class="node-label">${item.sku_name}</span>: 
                    <span class="node-value">${item.qty_capacity}</span> 
                    <span>(Level ${item.level}, ID: ${item.id})</span>
                    <span class="node-actions">
                        <button class="btn btn-danger delete" data-id="${item.id}">Delete</button>
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

        console.log('Tree data to save:', treeData);
        console.log('Flatten data to save:',  flattenHierarchy(treeData));
        
        // Flatten the tree data
        var flatData = flattenHierarchy(treeData);
        
        // Create a form dynamically
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/bom/edit-detail'; // Sesuaikan dengan route Laravel Anda
        
        // Add CSRF token (Laravel requirement)
        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfToken);
        
        // Add the flattened data as JSON
        var dataInput = document.createElement('input');
        dataInput.type = 'hidden';
        dataInput.name = 'data';
        dataInput.value = JSON.stringify(flatData);
        form.appendChild(dataInput);

        // Add the flattened data as JSON
        var bomIdInput = document.createElement('input');
        bomIdInput.type = 'hidden';
        bomIdInput.name = 'bom_id';
        bomIdInput.value = $('#bom_id').val();
        form.appendChild(bomIdInput);
        
        // Append form to body and submit
        document.body.appendChild(form);
        form.submit();
        
        // Clean up
        document.body.removeChild(form);
    }

    function flattenHierarchy(data, parentId = null) {
    let result = [];
    
    $.each(data, function(index, item) {
        // Buat objek flat dengan properti yang diinginkan
        let flatItem = {
            rec_key: item.id,
            sku_id: item.sku_id,
            sku_name: item.sku_name,
            qty_capacity: item.qty_capacity,
            qty_each_unit: item.qty_each_unit,
            level: item.level,
            description: item.level,
            rec_parent_key: parentId
        };
        
        // Tambahkan ke hasil
        result.push(flatItem);
        
        // Jika ada children, proses recursively
        if (item.children && item.children.length > 0) {
            let childItems = flattenHierarchy(item.children, item.id);
            result = result.concat(childItems);
        }
    });
    
    return result;
}

    // Event listeners
    $('#level').on('change', updateParentOptions);
    $('#addBtn').on('click', addDataToTree);
    $('#saveBtn').on('click', saveTreeData);
    

    
    // =========== HANDLING PARAM
    function populateSelectSku(title, master_data, element) {
        element.empty();
        element.append('<option value="">-- Select ' + title + " --</option>");
        master_data.forEach((data) => {
            element.append(
                `<option sku_id="${data.sku_id}" unit="${data.sku_procurement_unit}" value="${data.id}">${data.sku_name}</option>`
            );
        });
    }

    function initParam() {
      return fetchSkuMaster()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                skuData = data;
                populateSelectSku("Sku", data, $("[name=sku_id]"));
            })
            .catch((err) => {
                console.error("Error get Sku:", err);
            });
    }
    
    function fetchSkuMaster() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/sku-part-information",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching terms master:", err);
                    reject(err);
                },
            });
        });
    }


 function loadSavedItem(){
    const data = JSON.parse($('[name=data_saved]').val());
    //   const id = item.id // Use our auto-increment ID
    //     const sku_id = item.sku_id
    //     const sku_name = item.description
    //     const qty_capacity =  item.qty_capacity
    //     const qty_each_unit =  item.qty_each_unit
    //     const  description = item.description
    data.forEach(item => {  
        const level =item.level
        const itemMaster = skuData.find(i => i.id == item.sku_id)
            const newItem = {
               id:  parseInt(item.rec_key), // Use our auto-increment ID
               sku_id: item.sku_id,
                sku_name: itemMaster.sku_name,
               qty_capacity:  item.qty_capacity,
               qty_each_unit:  item.qty_each_unit,
                description: item.description,
               level: item.level,
                children: []
            };
            
            if (level === 1) {
                // Add to root level
                treeData.push(newItem);
            } else {
                // Find the parent and add to its children
                const parentId = parseInt(item.rec_parent_key);
                
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
            $('#sku_id, #qty_capacity, #qty_each_unit, #description').val('');
            
            // Update UI
            updateLevelOptions();
            updateParentOptions();
            renderTree();
            debugger;
        });
    }

    // Initialize
    updateLevelOptions();
    updateParentOptions();
    initParam().then(() => {
        loadSavedItem();
    });

    
});