

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="quantity_di"><i class="zmdi zmdi-collection-item-9-plus material-icons-name"></i></label>
                {{ html()->text('quantity_di')
                    ->placeholder('Quantity of DI')
                    ->attribute('id', 'quantity_di')
                    ->attribute('value', (isset($quantity_di)?$quantity_di:''))
                }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="catalog_number"><i class="zmdi zmdi-format-list-numbered material-icons-name"></i></label>
                {{ html()->text('catalog_number')
                    ->placeholder('Catalog Number')
                    ->attribute('id', 'catalog_number')
                    ->attribute('value', (isset($catalogNumber)?$catalogNumber:'')) 
                }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="quantity_di"><i class="zmdi zmdi-collection-item material-icons-name"></i></label>
                {{ html()->text('item_name')
                    ->placeholder('Item Name')
                    ->attribute('id', 'item_name')
                    ->attribute('value', (isset($itemName)?$itemName:''))
                }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="catalog_number"><i class="zmdi zmdi-paypal-alt material-icons-name"></i></label>
                {{ html()->text('price')
                    ->placeholder('Price')
                    ->attribute('id', 'price')
                    ->attribute('value', (isset($price)?$price:'')) 
                }}
            </div>
        </div>
    </div>

    