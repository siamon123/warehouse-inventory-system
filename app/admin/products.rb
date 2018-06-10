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
    inputs 'Financial' do
      input :buy_price, :as => :number, :type => :decimal
      input :sell_price, :as => :number, :type => :decimal
      input :quantity, :as => :number, :type => :integer
    end
    actions
  end

  show do |product|
    div do
      h5 product.name
      product.categories.each do |category|
        h6 category.name
      end
      h5 product.media_src
    end
    div do
      h5 product.buy_price
      h5 product.sell_price
      h5 product.quantity
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
