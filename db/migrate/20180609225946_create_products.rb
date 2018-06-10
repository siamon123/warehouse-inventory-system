class CreateProducts < ActiveRecord::Migration[5.2]
  def change
    create_table :products do |t|
      t.string :name
      t.integer :quantity
      t.decimal :buy_price, precision: 25, scale: 2
      t.decimal :sell_price, precision: 25, scale: 2
      t.string :media_src

      t.timestamps
    end
  end
end
