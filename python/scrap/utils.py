import pandas as pd

def split_odds(df):
    def split_odds_column(odds):
        parts = odds.split('.')
        if len(parts) >= 4:
            var1 = float(parts[0] + '.' + parts[1][:2])
            var2 = float(parts[1][2:] + '.' + parts[2][:2])
            var3 = float(parts[2][2:] + '.' + parts[3][:2])
            
            odd1 = var1
            odd2 = var2
            odd3 = var3
            total_stake = 100
            arb_percentage = (1 / odd1) + (1 / odd2) + (1 / odd3)
    
            stake1 = (total_stake / (odd1 * arb_percentage))
            stake2 = (total_stake / (odd2 * arb_percentage))
            stake3 = (total_stake / (odd3 * arb_percentage))
            
            total_payout = stake1 * odd1
            profit = total_payout - total_stake
            
            return pd.Series([stake1, stake2, stake3, total_payout, profit])
        
        elif len(parts) == 3:
            var1 = float(parts[0] + '.' + parts[1][:2])
            var2 = float(parts[1][2:] + '.' + parts[2][:2])
            
            odd1 = var1
            odd2 = var2
            total_stake = 100
            arb_percentage = (1 / odd1) + (1 / odd2)
    
            stake1 = (total_stake / (odd1 * arb_percentage))
            stake2 = (total_stake / (odd2 * arb_percentage))
            
            total_payout = stake1 * odd1
            profit = total_payout - total_stake
            
            return pd.Series([stake1, stake2, total_payout, profit])
        else:
            return pd.Series([None, None, None])

    for col in df.columns[1:]:
        if df[col].dtype == object:
            try:
                split_data = df[col].apply(split_odds_column)
                new_col_names = [f"{col}_part{i+1}" for i in range(len(split_data.columns))]
                split_data.columns = new_col_names
                df = df.drop(columns=[col]).join(split_data)
  
