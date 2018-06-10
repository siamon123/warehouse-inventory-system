ActiveAdmin.register Product do
# See permitted parameters documentation:
# https://github.com/activeadmin/activeadmin/blob/master/docs/2-resource-customization.md#setting-up-strong-parameters
#
  permit_params :name, :quantity, :buy_price,
                :sell_price, :media_src, category_ids: []

  form title: 'Products' do |f|
    inputs 'Details' do
      input :name
      input :categories, :as => :check_boxes, :collection => Category.all
      input :media_src
    end
    inputs 'Financial Details' do
      input :buy_price, :as => :number, :type => :decimal
      input :sell_price, :as => :number, :type => :decimal
      input :quantity, :as => :number, :type => :integer
    end
    actions
  end

  show do |product|
    panel 'Details' do
      table_for product do
        column(:name) {product.name}
        column(:categories) {product.categories.map(&:name).compact}
      end
    end
    panel 'Image' do
      img src: product.media_src, style: 'max-height:100px'
    end
    panel 'Financial Details' do
      table_for product do
        column 'Buy Price', :buy_price
        column 'Sell Price', :sell_price
        column 'Quantity', :quantity
      end
    end
  end

  index do |products|
    selectable_column
    column :name
    column 'Categories' do |product|
      product.categories.map(&:name).compact
    end
    column :media_src
    column :buy_price
    column :sell_price
    column :quantity
    actions
  end

end
